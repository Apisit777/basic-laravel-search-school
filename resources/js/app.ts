// resources/js/realtime.ts

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

declare const toastr: any;

console.log('🔥 realtime.ts loaded');

// ---- ให้ TS รู้จัก property บน window ----
declare global {
  interface Window {
    Pusher: typeof Pusher;
    Echo: Echo<any>;  // 👈 ใส่ <any> ให้มัน
    updateAccountBadge: (delta: number) => void;
  }
}

window.Pusher = Pusher;

const echo = new Echo({
  broadcaster: 'reverb',
  key: import.meta.env.VITE_REVERB_APP_KEY,
  wsHost: import.meta.env.VITE_REVERB_HOST,
  wsPort: Number(import.meta.env.VITE_REVERB_PORT || 8080),
  wssPort: Number(import.meta.env.VITE_REVERB_PORT || 8080),
  forceTLS: import.meta.env.VITE_REVERB_SCHEME === 'https',
  enabledTransports: ['ws', 'wss'],
  withCredentials: true,
});

window.Echo = echo;

// ---------- helper หา element ----------
function getAccountBadgeEl(): HTMLElement | null {
  const el = document.getElementById('account-badge') as HTMLElement | null;
  if (!el) {
    console.warn('[realtime] #account-badge not found on this page');
  }
  return el;
}

// ---------- localStorage helper ----------
function getStoredAccountBadge(): number {
  try {
    const raw = localStorage.getItem('account_badge_count');
    if (!raw) return 0;
    const n = Number(raw);
    return Number.isFinite(n) && n >= 0 ? n : 0;
  } catch {
    return 0;
  }
}

function setStoredAccountBadge(value: number) {
  try {
    localStorage.setItem('account_badge_count', String(value));
  } catch {
    // ignore
  }
}

// ---------- DOM update ----------
function renderAccountBadge(count: number) {
  const el = getAccountBadgeEl();
  if (!el) return;

  const safe = Math.max(0, count);

  el.dataset.count = String(safe);
  el.textContent = safe > 99 ? '99+' : String(safe);
  el.classList.toggle('hidden', safe === 0);
}

function renderAccountNotiListBadge(count: number) {
  const el = document.getElementById('account-badge-top') as HTMLElement | null;
  if (!el) {
    console.warn('[realtime] account-badge-top not found on this page');
    return;
  }

  const safe = Math.max(0, count);

  el.textContent = safe > 99 ? '99+' : String(safe);
  el.classList.toggle('hidden', safe === 0);

  console.log('🟥 renderAccountNotiListBadge', { count: safe });
}

function updateAccountBadge(delta: number) {
  const current = getStoredAccountBadge();
  const next = Math.max(0, current + delta);

  setStoredAccountBadge(next);
  renderAccountBadge(next);

  // 🔵 badge ปุ่ม "☰ รายการแจ้งเตือน"
  renderAccountNotiListBadge(next);

  console.log('🔢 updateAccountBadge', {
    from: current,
    delta,
    to: next,
  });
}

(window as any).updateAccountBadge = updateAccountBadge;

// ---- hydrate ตอนโหลดหน้า ----
document.addEventListener('DOMContentLoaded', () => {
  const current = getStoredAccountBadge();
  renderAccountBadge(current);
  renderAccountNotiListBadge(current);
});

function showRealtimeToastr(message: string) {
  const hasToastr = typeof toastr !== 'undefined';

  console.log('[realtime] try show toastr', {
    message,
    hasToastr,
    path: window.location.pathname,
  });

  if (!hasToastr) {
    console.warn('[realtime] toastr is UNDEFINED. ตรวจว่าโหลดไฟล์ toastr.js แล้วหรือยัง และลำดับ script อยู่ก่อน app.js หรือไม่');
    return;
  }

  const customToastCss = `
  .toast-custom-info {
      background-color: #05395D !important;
      color: #fff !important;
      border: 2px solid #1f95de !important;
  }
  `;

  const styleTag = document.createElement("style");
  styleTag.innerHTML = customToastCss;
  document.head.appendChild(styleTag);

  // 🔹 แปลง \n เป็น <br> เพื่อให้ขึ้นบรรทัดใหม่
  const htmlMessage = message.replace(/\n/g, '<br>');

  try {
    toastr.info(htmlMessage, '', {
      closeButton: true,
      progressBar: true,
      positionClass: 'toast-bottom-right',
      toastClass: 'toast-custom-info',
      timeOut: 7500,
      extendedTimeOut: 1000,
      showDuration: 300,
      hideDuration: 1000,
      showMethod: 'fadeIn',
      hideMethod: 'fadeOut',
      // 🔹 บอก toastr ว่าให้แสดง HTML ได้
      escapeHtml: false,
    });
  } catch (e) {
    console.error('[realtime] ERROR while calling toastr', e);
  }
}

// ด้านล่างสุดของ realtime.ts (หลังประกาศ renderAccountBadge แล้ว)
window.addEventListener('storage', (event: StorageEvent) => {
  // ---------- badge count ----------
  if (event.key === 'account_badge_count') {
    const next = Number(event.newValue || '0') || 0;
    renderAccountBadge(next);
    renderAccountNotiListBadge(next);
    // ❌ ไม่ต้องเรียก showRealtimeToastr ที่นี่แล้ว
  }

  // ---------- toast message ล่าสุด ----------
  if (event.key === 'account_last_noti_message') {
    const msg = event.newValue || 'แจ้งเตือนมีการเพิ่ม Product ใหม่!';
    console.log('🟣 storage event account_last_noti_message', { msg });

    if (window.location.pathname.startsWith('/account')) {
      showRealtimeToastr(msg);
    }
  }

  // ---------- noti per PRODUCT ----------
  if (event.key === 'account_noti_products') {
    console.log('🟣 storage event account_noti_products', {
      from: event.oldValue,
      to: event.newValue,
    });

    // อยู่หน้า /account แล้ว และมีฟังก์ชัน refreshAccountTable ให้เรียก
    if (
      window.location.pathname.startsWith('/account') &&
      typeof (window as any).refreshAccountTable === 'function'
    ) {
      (window as any).refreshAccountTable();
    }
  }
});

// ========== จัดการ list รหัสสินค้าที่ต้องแจ้งเตือน (per product) ==========

function getNotiProducts(): string[] {
  try {
    const raw = localStorage.getItem('account_noti_products');
    if (!raw) return [];
    const parsed = JSON.parse(raw);
    return Array.isArray(parsed) ? parsed.map(v => String(v)) : [];
  } catch (e) {
    console.warn('[Realtime] getNotiProducts error', e);
    return [];
  }
}

function setNotiProducts(list: string[]) {
  try {
    localStorage.setItem('account_noti_products', JSON.stringify(list));
  } catch {
    // ignore
  }
}

function pushNotiProduct(product: string) {
  const code = String(product);
  const list = getNotiProducts();

  if (!list.includes(code)) {
    list.unshift(code);      // ตัวล่าสุดอยู่บนสุด
  }

  const trimmed = list.slice(0, 100);
  setNotiProducts(trimmed);

  console.log('[Realtime] pushNotiProduct', { code, trimmed });
}

// ให้หน้าอื่นเรียกได้ เช่น หน้า create
(window as any).pushNotiProduct = pushNotiProduct;

// ✅ ฟังก์ชันกลาง – ใช้ทุกที่เวลามี product ใหม่
function addAccountNotification(productCode: string, brand?: string) {
  const code = String(productCode);
  const brandName = brand ? String(brand) : '';

  // 1) เพิ่ม badge +1
  updateAccountBadge(+1);

  // 2) เพิ่มรหัสลง account_noti_products
  pushNotiProduct(code);

  // 3) เก็บรายละเอียดชุดล่าสุดไว้ใน localStorage
  try {
    localStorage.setItem(
      'account_noti_last_detail',
      JSON.stringify({ brand: brandName, product: code })
    );
  } catch (e) {
    console.warn('[Realtime] set account_noti_last_detail error', e);
  }

  console.log('[Realtime] addAccountNotification', { code });
}

// ให้หน้าอื่นเรียกใช้ได้ (create page, edit page ฯลฯ)
(window as any).addAccountNotification = addAccountNotification;


console.log('Echo realtime loaded');

// ---- subscribe Reverb channel ----
window.Echo.private('account.global')
  .listen('.account.approval.requested', (e: any) => {
    console.log('📡 EVENT account.approval.requested (broadcast)', e);

    const code =
      e?.product ??         // 👈 ต้องมีบรรทัดนี้ เพราะ broadcastWith ส่ง key ชื่อ product
      e?.data?.product ??   // 👈 เพิ่มกรณีที่ nested
      e?.PRODUCT ??
      e?.product_id ??
      e?.productCode ??
      null;

    const brand =
      e?.brand ??
      e?.data?.brand ??     // 👈 เหมือนกัน
      '';

    if (code) {
      addAccountNotification(String(code), String(brand));  // ⬅ จะไปเรียก pushNotiProduct ข้างบน
    } else {
      console.warn('[Realtime] event ไม่มี product code', e);
      updateAccountBadge(+1);
    }

    if (window.location.pathname.startsWith('/account')) {
      if ((window as any).refreshAccountTable) {
        (window as any).refreshAccountTable();
      }
      // Toast เต็มรูปแบบ
      const msg =
        `แจ้งเตือนมีการเพิ่ม Product ใหม่!\n` +
        `- Brand ${brand || '-'}\n` +
        `- รหัสสินค้า ${code || '-'}`;

      showRealtimeToastr(msg);
    }
  });

// ✅ ลบแจ้งเตือนของ product หนึ่งตัว (ใช้ตอน Save ตั้งราคา)
function clearAccountNotiForProduct(productCode: string) {
  const code = String(productCode);

  // 1) เอา code นี้ออกจาก list ใน localStorage
  const list = getNotiProducts();          // ใช้ฟังก์ชันเดิมของคุณ
  const filtered = list.filter(v => v !== code);
  setNotiProducts(filtered);

  // 2) นับจำนวนแจ้งเตือนที่เหลือ แล้ว sync กับ account_badge_count
  const nextCount = filtered.length;

  setStoredAccountBadge(nextCount);        // อัปเดต localStorage: account_badge_count
  renderAccountBadge(nextCount);           // เมนูซ้าย Account
  renderAccountNotiListBadge(nextCount);   // ปุ่ม "รายการแจ้งเตือน" ด้านบน

  // 3) เคลียร์ badge บนปุ่ม "+ Schedule" ของสินค้าตัวนี้
  //    (สมมติคุณให้ badge มี class = "account-schedule-badge" + data-product="รหัสสินค้า")
  document
    .querySelectorAll<HTMLElement>(
      `.account-schedule-badge[data-product="${code}"]`
    )
    .forEach((el) => {
      el.textContent = '';           // ไม่ต้องแสดงตัวเลขแล้ว
      el.classList.add('hidden');    // ซ่อน badge
    });

  // 4) ถ้าไม่เหลือ noti แล้ว เคลียร์ localStorage ตัวอื่นที่เกี่ยวข้องด้วย
  if (nextCount === 0) {
    localStorage.removeItem('account_last_noti_message');
    localStorage.removeItem('account_noti_last_detail');
    // ถ้าต้องการ reset ทุกอย่างจริง ๆ จะลบ account_noti_products ด้วยก็ได้
    // localStorage.removeItem('account_noti_products');
  }

  console.log('[Realtime] clearAccountNotiForProduct', { code, nextCount });
}

// ให้หน้าอื่นเรียกใช้ได้ (เช่นหน้า Schedule)
(window as any).clearAccountNotiForProduct = clearAccountNotiForProduct;