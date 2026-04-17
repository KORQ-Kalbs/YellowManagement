/**
 * Modal & Transition Animations Module
 * Handles modal animations, dropdowns, and page transitions
 */

import gsap from "gsap";

export function initModalAnimations() {
    // Variant modal animation
    const variantModal = document.getElementById("variantModal");
    if (variantModal) {
        const observer = new MutationObserver(() => {
            const isHidden = variantModal.classList.contains("hidden");
            if (!isHidden) {
                // Modal is shown
                gsap.from(variantModal, {
                    opacity: 0,
                    duration: 0.2,
                    ease: "power2.out",
                });
                const modalContent = variantModal.querySelector(
                    '[role="dialog"], > div > div:last-child',
                );
                if (modalContent) {
                    gsap.from(modalContent, {
                        opacity: 0,
                        y: 30,
                        duration: 0.3,
                        ease: "back.out",
                    });
                }
            }
        });

        observer.observe(variantModal, {
            attributes: true,
            attributeFilter: ["class"],
        });
    }
}

export function animateModalOpen(element) {
    // Animate backdrop
    const backdrop = element.querySelector('[class*="bg-black"]');
    if (backdrop) {
        gsap.from(backdrop, {
            opacity: 0,
            duration: 0.2,
            ease: "power2.out",
        });
    }

    // Animate content
    const content = element.querySelector(
        '[class*="bg-white"], [class*="rounded"]',
    );
    if (content && !content.classList.contains("bg-black")) {
        gsap.from(content, {
            opacity: 0,
            scale: 0.95,
            y: 20,
            duration: 0.3,
            ease: "back.out",
        });
    }
}

export function animateDropdown(dropdown) {
    gsap.from(dropdown, {
        opacity: 0,
        y: -10,
        duration: 0.2,
        ease: "power2.out",
    });
}

export function animatePageTransition() {
    // Fade in main content
    const mainContent = document.querySelector("main");
    if (mainContent) {
        gsap.from(mainContent, {
            opacity: 0,
            y: 10,
            duration: 0.4,
            ease: "power2.out",
        });
    }
}
