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

initTWE({ Modal, Ripple, Tooltip, Dropdown });

window.Alpine = Alpine

Alpine.plugin(persist)

Alpine.start()
