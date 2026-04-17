/**
 * Button Animations Module
 * Handles hover and click animations for buttons using GSAP
 */

import gsap from "gsap";

export function initButtonAnimations() {
    // Size/Variant buttons animation
    const sizeButtons = document.querySelectorAll(
        ".size-option-btn, .variant-btn",
    );
    sizeButtons.forEach((btn) => {
        btn.addEventListener("mouseenter", function () {
            gsap.to(this, {
                scale: 1.05,
                duration: 0.2,
                ease: "power2.out",
                boxShadow: "0 4px 12px rgba(234, 179, 8, 0.4)",
            });
        });

        btn.addEventListener("mouseleave", function () {
            gsap.to(this, {
                scale: 1,
                duration: 0.2,
                ease: "power2.out",
                boxShadow: "0 0px 0px rgba(0, 0, 0, 0)",
            });
        });
    });

    // Submit buttons animation
    const submitButtons = document.querySelectorAll(
        'button[type="submit"], .btn-submit',
    );
    submitButtons.forEach((btn) => {
        btn.addEventListener("click", function () {
            gsap.to(this, {
                scale: 0.95,
                duration: 0.1,
                ease: "power2.out",
                onComplete: () => {
                    gsap.to(this, {
                        scale: 1,
                        duration: 0.1,
                        ease: "back.out",
                    });
                },
            });
        });
    });
}

export function animateButtonEntry(element) {
    gsap.from(element, {
        opacity: 0,
        scale: 0.8,
        duration: 0.3,
        ease: "back.out",
    });
}
