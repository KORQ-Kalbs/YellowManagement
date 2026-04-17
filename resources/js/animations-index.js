/**
 * Animations Index
 * Central point for initializing all animations
 */

import {
    initButtonAnimations,
    animateButtonEntry,
} from "./animations/button-animations.js";
import {
    initCardAnimations,
    animateCartItems,
    animateTableRows,
    animateStatCard,
    pulseAnimation,
} from "./animations/card-animations.js";
import {
    initModalAnimations,
    animateModalOpen,
    animateDropdown,
    animatePageTransition,
} from "./animations/modal-animations.js";

export function initAllAnimations() {
    // Initialize all animation systems
    initButtonAnimations();
    initCardAnimations();
    initModalAnimations();
    animatePageTransition();

    // Observe for dynamically added elements
    observeDynamicElements();
}

function observeDynamicElements() {
    const cartContainer = document.getElementById("cartItems");
    if (cartContainer) {
        const observer = new MutationObserver(() => {
            animateCartItems();
            initButtonAnimations();
        });
        observer.observe(cartContainer, { childList: true, subtree: true });
    }

    const tableBody = document.querySelector("tbody");
    if (tableBody) {
        const observer = new MutationObserver(() => {
            animateTableRows();
        });
        observer.observe(tableBody, { childList: true });
    }
}

// Export individual functions for manual use
export {
    initButtonAnimations,
    animateButtonEntry,
    initCardAnimations,
    animateCartItems,
    animateTableRows,
    animateStatCard,
    pulseAnimation,
    initModalAnimations,
    animateModalOpen,
    animateDropdown,
    animatePageTransition,
};
