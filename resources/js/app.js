import './bootstrap';
import Alpine from 'alpinejs'
import persist from '@alpinejs/persist'
import {
    Modal,
    Ripple,
    initTWE,
  } from "tw-elements";

initTWE({ Modal, Ripple });

window.Alpine = Alpine

Alpine.plugin(persist)

Alpine.start()
