import './bootstrap';
import Alpine from 'alpinejs'
import persist from '@alpinejs/persist'
import {
    Modal,
    Ripple,
    Tooltip,
    Dropdown,
    initTWE,
  } from "tw-elements";

import './app.ts'; // 👈 ให้ Vite โหลด Echo + Reverb เข้า bundle เดียวกัน

initTWE({ Modal, Ripple, Tooltip, Dropdown });

window.Alpine = Alpine

Alpine.plugin(persist)

Alpine.start()


document.addEventListener('DOMContentLoaded', () => {
  const el = document.getElementById('pageLoading');
  if (!el) return;

  const show = () => el.classList.add('is-active');
  const hide = () => el.classList.remove('is-active');

  // ให้เรียกได้จากที่อื่น
  window.PageLoading = { show, hide };

  // กันกรณี BFCache / กลับหน้าเดิม
  window.addEventListener('pageshow', hide);
  window.addEventListener('popstate', hide);

  const isBootstrapModalTrigger = (node) => {
    if (!node) return false;
    return (
      node.getAttribute('data-bs-toggle') === 'modal' ||
      node.getAttribute('data-toggle') === 'modal' ||
      (node.getAttribute('data-bs-target') || node.getAttribute('data-target') || '').startsWith('#')
    );
  };

  const isInsideModal = (node) => !!node?.closest?.('.modal');

  // ✅ โชว์ loading เฉพาะกรณี "จะ navigate จริง"
  document.addEventListener('click', (e) => {
    const trigger = e.target.closest('a,button');
    if (!trigger) return;

    // 1) ปุ่ม/ลิงก์เปิด modal => ห้ามโชว์
    if (isBootstrapModalTrigger(trigger) || isInsideModal(trigger)) {
      hide();
      return;
    }

    // 2) ถ้าเป็น BUTTON ส่วนใหญ่คือ action ในหน้าเดิม (เปิด modal/ajax)
    if (trigger.tagName === 'BUTTON') {
      const type = (trigger.getAttribute('type') || 'button').toLowerCase();
      if (type !== 'submit') {
        // button ธรรมดา = ไม่ใช่เปลี่ยนหน้า
        hide();
        return;
      }
      // submit จะไปจับใน submit event อีกที
      return;
    }

    // 3) A tag
    const href = (trigger.getAttribute('href') || '').trim();
    const target = trigger.getAttribute('target');

    // link ที่ไม่ไปไหน
    if (!href || href === '#' || href.startsWith('javascript:') || href.startsWith('#')) {
      hide();
      return;
    }
    if (target === '_blank' || trigger.hasAttribute('download')) return;

    // เฉพาะ same-origin เท่านั้น
    let url;
    try { url = new URL(href, window.location.href); } catch { return; }
    if (url.origin !== window.location.origin) return;

    // ✅ ถ้ามี key กด (ctrl/cmd/shift) ให้เปิดแท็บใหม่ ไม่โชว์
    if (e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) return;

    show();

    // ✅ Watchdog: ถ้า 1.5 วิแล้วยัง URL เดิม -> hide (แปลว่าไม่ได้ navigate)
    const current = window.location.href;
    setTimeout(() => {
      if (window.location.href === current) hide();
    }, 1500);
  });

  // submit form -> โชว์ แล้วกันค้างด้วย watchdog
  document.addEventListener('submit', (e) => {
    // ถ้า submit อยู่ใน modal ส่วนมากคือ ajax/filter ไม่ใช่ไปหน้าใหม่
    if (e.target?.closest?.('.modal')) {
      hide();
      return;
    }

    show();
    const current = window.location.href;
    setTimeout(() => {
      if (window.location.href === current) hide();
    }, 3000);
  });

  // ✅ Bootstrap: เมื่อ modal โผล่ขึ้นมา ให้ hide แน่นอน
  document.addEventListener('shown.bs.modal', hide);
  document.addEventListener('hidden.bs.modal', hide);

  // ✅ ถ้าโปรเจกต์ใช้ jQuery/Ajax (DataTables ชอบใช้) => ajax จบให้ hide
  if (window.jQuery) {
    window.jQuery(document).ajaxStop(hide);
  }

  // ✅ กันค้างสุดท้าย: ไม่ว่ากรณีไหน 10 วิต้องหาย
  setInterval(() => {
    // ถ้า overlay เปิดค้างนานเกินไปให้ปิดเอง
    if (el.classList.contains('is-active')) hide();
  }, 10000);
});
