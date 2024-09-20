import './bootstrap';
import Alpine from 'alpinejs'
import persist from '@alpinejs/persist'
import {
    Modal,
    Ripple,
    Tooltip,
    initTWE,
  } from "tw-elements";

initTWE({ Modal, Ripple, Tooltip });

window.Alpine = Alpine

Alpine.plugin(persist)

Alpine.start()
