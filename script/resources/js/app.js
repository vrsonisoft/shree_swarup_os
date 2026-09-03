import "./bootstrap";
import "./shop-client-menu";
import { initFlowbite } from "flowbite";
// import './sidebar';
// import './sidebar';
// import './charts';
import ApexCharts from "apexcharts";
import swal from "sweetalert2";
window.Swal = swal;
window.ApexCharts = ApexCharts;

import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import "flatpickr/dist/themes/dark.css";


window.flatpickr = flatpickr;

// Skin theme helper (runtime swappable via `themes.css` + `tt-theme` class)
function getSkinColor(opacity = 1) {
    const raw = getComputedStyle(document.documentElement)
        .getPropertyValue('--color-base')
        .trim();

    if (!raw) return `rgba(0,0,0,${opacity})`;
    return `rgba(${raw}, ${opacity})`;
}
window.getSkinColor = getSkinColor;


// import './dark-mode';

// Check localStorage immediately to set initial state
if (localStorage.getItem("menu-collapsed") === "true") {
    // Add a class to body or html to handle initial state
    document.documentElement.classList.add('menu-collapsed');
}

document.addEventListener("livewire:navigating", () => {
    // Mutate the HTML before the page is navigated away...
    initFlowbite();
});

document.addEventListener('DOMContentLoaded', () => {
    initializeThemeToggle();
});

document.addEventListener('livewire:load', () => {
    initializeThemeToggle();
});

// Initialize theme toggle safely and idempotently
function initializeThemeToggle() {
    const themeToggleBtn = document.getElementById("theme-toggle");
    const themeToggleDarkIcon = document.getElementById("theme-toggle-dark-icon");
    const themeToggleLightIcon = document.getElementById("theme-toggle-light-icon");

    // Ensure html has correct theme class before manipulating icons
    if (localStorage.getItem('color-theme') === 'dark' ||
        (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

    // If required elements aren't present yet, do nothing
    if (!themeToggleBtn || !themeToggleDarkIcon || !themeToggleLightIcon) {
        return;
    }

    // Set initial icon visibility based on current theme
    if (document.documentElement.classList.contains('dark')) {
        themeToggleLightIcon.classList.remove('hidden');
        themeToggleDarkIcon.classList.add('hidden');
    } else {
        themeToggleDarkIcon.classList.remove('hidden');
        themeToggleLightIcon.classList.add('hidden');
    }

    // Avoid attaching multiple listeners
    if (themeToggleBtn.dataset.initialized === 'true') {
        return;
    }
    themeToggleBtn.dataset.initialized = 'true';

    let event = new Event("dark-mode");
    themeToggleBtn.addEventListener("click", function () {
        // Toggle html class and persist
        if (localStorage.getItem("color-theme")) {
            if (localStorage.getItem("color-theme") === "light") {
                document.documentElement.classList.add("dark");
                localStorage.setItem("color-theme", "dark");
            } else {
                document.documentElement.classList.remove("dark");
                localStorage.setItem("color-theme", "light");
            }
        } else {
            if (document.documentElement.classList.contains("dark")) {
                document.documentElement.classList.remove("dark");
                localStorage.setItem("color-theme", "light");
            } else {
                document.documentElement.classList.add("dark");
                localStorage.setItem("color-theme", "dark");
            }
        }

        // Sync icons
        if (document.documentElement.classList.contains('dark')) {
            themeToggleLightIcon.classList.remove('hidden');
            themeToggleDarkIcon.classList.add('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
            themeToggleLightIcon.classList.add('hidden');
        }

        document.dispatchEvent(event);
    });
}

// Observe for the theme toggle button being (re)inserted by Livewire and init once
function observeThemeToggleMount() {
    // Initialize now if present
    initializeThemeToggle();

    const observer = new MutationObserver(() => {
        const btn = document.getElementById('theme-toggle');
        if (btn && btn.dataset.initialized !== 'true') {
            initializeThemeToggle();
        }
    });
    if (document.body) {
        observer.observe(document.body, { childList: true, subtree: true });
    } else {
        document.addEventListener('DOMContentLoaded', () => {
            observer.observe(document.body, { childList: true, subtree: true });
        });
    }
}

function applySidebarCollapseState() {
    const isCollapsed = localStorage.getItem("menu-collapsed") === "true";
    const body = document.body;
    const html = document.documentElement;
    const openIcon = document.getElementById('toggle-sidebar-open');
    const closeIcon = document.getElementById('toggle-sidebar-close');

    if (isCollapsed) {
        body.classList.add('menu-collapsed');
        html.classList.add('menu-collapsed');
        if (openIcon) openIcon.classList.remove('hidden');
        if (closeIcon) closeIcon.classList.add('hidden');
    } else {
        body.classList.remove('menu-collapsed');
        html.classList.remove('menu-collapsed');
        if (openIcon) openIcon.classList.add('hidden');
        if (closeIcon) closeIcon.classList.remove('hidden');
    }
}

document.addEventListener("livewire:navigated", () => {
    // Ensure theme toggle initializes even if later blocks fail
    observeThemeToggleMount();

    // Apply sidebar state
    applySidebarCollapseState();

    const toggleSidebarBtn = document.getElementById('toggle-sidebar');
    if (toggleSidebarBtn && toggleSidebarBtn.dataset.initialized !== 'true') {
        toggleSidebarBtn.dataset.initialized = 'true';
        toggleSidebarBtn.addEventListener('click', function(event) {
            event.preventDefault();
            const current = localStorage.getItem("menu-collapsed") === "true";
            localStorage.setItem("menu-collapsed", (!current).toString());
            applySidebarCollapseState();
        });
    }


    // (Re)initialize theme toggle on every Livewire navigation (already attempted at top)
    observeThemeToggleMount();

    const sidebar = document.getElementById('sidebar');
    if (sidebar) {
        const toggleSidebarMobile = (
            sidebar,
            sidebarBackdrop,
            toggleSidebarMobileHamburger,
            toggleSidebarMobileClose
        ) => {
            sidebar.classList.toggle("hidden");
            sidebarBackdrop.classList.toggle("hidden");
            toggleSidebarMobileHamburger.classList.toggle("hidden");
            toggleSidebarMobileClose.classList.toggle("hidden");
        };

        const toggleSidebarMobileEl = document.getElementById(
            "toggleSidebarMobile"
        );
        const sidebarBackdrop = document.getElementById("sidebarBackdrop");
        const toggleSidebarMobileHamburger = document.getElementById(
            "toggleSidebarMobileHamburger"
        );
        const toggleSidebarMobileClose = document.getElementById(
            "toggleSidebarMobileClose"
        );
        const toggleSidebarMobileSearch = document.getElementById(
            "toggleSidebarMobileSearch"
        );

        if (toggleSidebarMobileSearch && sidebarBackdrop && toggleSidebarMobileHamburger && toggleSidebarMobileClose) {
            toggleSidebarMobileSearch.addEventListener("click", () => {
                toggleSidebarMobile(
                    sidebar,
                    sidebarBackdrop,
                    toggleSidebarMobileHamburger,
                    toggleSidebarMobileClose
                );
            });
        }

        if (toggleSidebarMobileEl && sidebarBackdrop && toggleSidebarMobileHamburger && toggleSidebarMobileClose) {
            toggleSidebarMobileEl.addEventListener("click", () => {
                toggleSidebarMobile(
                    sidebar,
                    sidebarBackdrop,
                    toggleSidebarMobileHamburger,
                    toggleSidebarMobileClose
                );
            });
        }

        if (sidebarBackdrop && toggleSidebarMobileHamburger && toggleSidebarMobileClose) {
            sidebarBackdrop.addEventListener("click", () => {
                toggleSidebarMobile(
                    sidebar,
                    sidebarBackdrop,
                    toggleSidebarMobileHamburger,
                    toggleSidebarMobileClose
                );
            });
        }
    }

    // Reinitialize Flowbite components
    initFlowbite();
});

let attrs = [
    "snapshot",
    "effects",
    // 'click',
    // 'id'
];

function snapKill() {
    document
        .querySelectorAll("div, nav, a, header")
        .forEach(function (element) {
            for (let i in attrs) {
                if (element.getAttribute(`wire:${attrs[i]}`) !== null) {
                    element.removeAttribute(`wire:${attrs[i]}`);
                }
            }
        });
}

window.addEventListener("load", (ev) => {
    snapKill();
});

function initPasswordToggles() {
    // Remove existing listeners to prevent duplicates
    document.removeEventListener('click', handlePasswordToggle);
    // Add single event listener on document
    document.addEventListener('click', handlePasswordToggle);
}

function handlePasswordToggle(event) {
    // Check if clicked element or its parent has toggle-password class
    const toggleButton = event.target.closest('.toggle-password');
    if (!toggleButton) return;

    // Find the closest parent div and get related elements
    const wrapper = toggleButton.closest('.relative');
    const passwordInput = wrapper.querySelector('.password');
    const eyeIcon = wrapper.querySelector('.eye-icon');
    const eyeSlashIcon = wrapper.querySelector('.eye-slash-icon');

    // Toggle password visibility
    const isPassword = passwordInput.type === "password";
    passwordInput.type = isPassword ? "text" : "password";

    // Toggle the icons
    eyeIcon.classList.toggle("hidden", isPassword);
    eyeSlashIcon.classList.toggle("hidden", !isPassword);
}

initPasswordToggles();

// Re-initialize when Livewire updates the DOM
document.addEventListener('livewire:navigated', () => {
    initPasswordToggles();
});

