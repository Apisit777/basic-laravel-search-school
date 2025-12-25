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
