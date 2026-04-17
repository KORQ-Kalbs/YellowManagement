/**
 * Card & Element Animations Module
 * Handles fade-in, slide-in, and bounce animations
 */

import gsap from "gsap";

export function initCardAnimations() {
    // Animate cards on scroll
    const cards = document.querySelectorAll('[data-animate="card"]');
    cards.forEach((card, index) => {
        gsap.from(card, {
            opacity: 0,
            y: 20,
            duration: 0.5,
            delay: index * 0.1,
            ease: "power2.out",
        });
    });
}

export function animateCartItems() {
    const cartItems = document.querySelectorAll('[data-animate="cart-item"]');
    cartItems.forEach((item, index) => {
        gsap.from(item, {
            opacity: 0,
            x: -20,
            duration: 0.3,
            delay: index * 0.05,
            ease: "power2.out",
        });
    });
}

export function animateTableRows() {
    const rows = document.querySelectorAll("tbody tr");
    rows.forEach((row, index) => {
        gsap.from(row, {
            opacity: 0,
            y: 10,
            duration: 0.4,
            delay: index * 0.05,
            ease: "power2.out",
        });
    });
}

export function animateStatCard(element) {
    gsap.from(element, {
        opacity: 0,
        scale: 0.95,
        duration: 0.5,
        ease: "back.out",
    });
}

export function pulseAnimation(element) {
    gsap.to(element, {
        boxShadow: "0 0 20px rgba(234, 179, 8, 0.6)",
        duration: 0.6,
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut",
    });
}
