import './bootstrap';
import Alpine from 'alpinejs'
import persist from '@alpinejs/persist'
// import {  Stepper, initTWE } from "tw-elements";

// initTWE({ Stepper });

window.Alpine = Alpine

Alpine.plugin(persist)

Alpine.start()
