# GSAP Animation System Usage Guide

## Quick Start

All animations are automatically initialized on page load. No additional setup required!

```javascript
// Animations auto-initialize
initAllAnimations(); // Called automatically in app.js
```

---

## Available Animation Functions

### Button Animations

**File**: `resources/js/animations/button-animations.js`

```javascript
// Automatically attached to buttons with these classes:
// - .size-option-btn
// - .variant-btn
// - button[type="submit"]
// - .btn-submit

// To manually animate an element:
import { animateButtonEntry } from "./animations/button-animations.js";

const btn = document.querySelector(".my-button");
animateButtonEntry(btn);
```

**Effects**:

- Hover: Scale 1.05 with yellow glow
- Click: Press effect (scale 0.95)
- Leave: Smooth return to normal

---

### Card Animations

**File**: `resources/js/animations/card-animations.js`

```javascript
import {
    initCardAnimations,
    animateCartItems,
    animateTableRows,
    animateStatCard,
    pulseAnimation,
} from "./animations/card-animations.js";

// Animate cards with data-animate="card"
initCardAnimations();

// Animate all current cart items
animateCartItems();

// Animate all table rows
animateTableRows();

// Animate a single stat card
animateStatCard(element);

// Add pulse effect to element
pulseAnimation(element);
```

**HTML Attributes**:

```html
<!-- Cards will animate on page load -->
<div data-animate="card">
    <!-- content -->
</div>

<!-- Cart items will animate -->
<div data-animate="cart-item">
    <!-- content -->
</div>
```

---

### Modal Animations

**File**: `resources/js/animations/modal-animations.js`

```javascript
import {
    initModalAnimations,
    animateModalOpen,
    animateDropdown,
    animatePageTransition,
} from "./animations/modal-animations.js";

// Initialize all modal observers
initModalAnimations();

// Manually animate a modal
const modal = document.getElementById("myModal");
animateModalOpen(modal);

// Animate dropdown
const dropdown = document.querySelector(".dropdown");
animateDropdown(dropdown);

// Animate page transition
animatePageTransition();
```

---

## Adding Custom Animations

### Example 1: Animate a Button on Click

```javascript
import gsap from "gsap";

const button = document.querySelector(".my-button");
button.addEventListener("click", () => {
    gsap.to(button, {
        rotate: 360,
        duration: 0.5,
        ease: "back.out",
    });
});
```

### Example 2: Stagger Animation for List Items

```javascript
import gsap from "gsap";

const items = document.querySelectorAll(".list-item");
gsap.from(items, {
    opacity: 0,
    y: 20,
    duration: 0.5,
    stagger: 0.1, // 0.1s delay between each
    ease: "power2.out",
});
```

### Example 3: Animate on Scroll

```javascript
import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

gsap.to(".element", {
    scrollTrigger: ".element",
    duration: 1,
    x: 100,
    ease: "power2.out",
});
```

---

## GSAP Common Methods

### `.to()` - Animate TO these values

```javascript
gsap.to(element, {
    duration: 0.5,
    opacity: 1,
    x: 100,
    ease: "power2.out",
});
```

### `.from()` - Animate FROM these values

```javascript
gsap.from(element, {
    duration: 0.5,
    opacity: 0,
    y: 20,
    ease: "power2.out",
});
```

### `.fromTo()` - Define both

```javascript
gsap.fromTo(
    element,
    { opacity: 0, scale: 0.5 },
    { opacity: 1, scale: 1, duration: 0.5 },
);
```

### `.timeline()` - Chain animations

```javascript
const tl = gsap.timeline();
tl.to(".box1", { duration: 0.5, x: 100 })
    .to(".box2", { duration: 0.5, x: 100 }, 0) // Start at same time
    .to(".box3", { duration: 0.5, x: 100 }, "+=0.5"); // After 0.5s
```

---

## Common GSAP Properties

```javascript
gsap.to(element, {
    // Position
    x: 100, // Move right 100px
    y: 50, // Move down 50px

    // Scale & Rotation
    scale: 1.2, // Zoom in
    rotate: 45, // Rotate 45 degrees

    // Opacity
    opacity: 0.5, // Semi-transparent

    // Size
    width: 300, // Set width
    height: 200, // Set height

    // Colors
    backgroundColor: "red",
    color: "white",

    // Box Shadow
    boxShadow: "0 4px 12px rgba(0,0,0,0.3)",

    // Timing
    duration: 0.5, // 500ms animation
    delay: 0.2, // Start after 200ms

    // Easing
    ease: "power2.out", // Different easing options

    // Callbacks
    onStart: () => {}, // Called when animation starts
    onComplete: () => {}, // Called when animation finishes

    // Repetition
    repeat: -1, // Repeat forever (-1) or N times
    yoyo: true, // Reverse animation
});
```

---

## Easing Functions

Popular ease options:

- `'power1.out'` - Smooth ease out
- `'power2.out'` - Smoother ease out
- `'power3.out'` - Very smooth ease out
- `'back.out'` - Bouncy ease out
- `'elastic.out'` - Springy ease out
- `'bounce.out'` - Bouncy ease
- `'sine.inOut'` - Smooth in and out
- `'expo.out'` - Fast ease out
- `'circ.out'` - Circular ease out

---

## Integration with Livewire

Animations automatically reinitialize after Livewire navigation:

```javascript
// Already handled in app.js
document.addEventListener("livewire:navigated", () => {
    setTimeout(initAllAnimations, 100);
});
```

If you add new elements dynamically:

```javascript
// Manually trigger animations for new elements
import { initButtonAnimations, animateCartItems } from "./animations-index.js";

// After adding new buttons
setTimeout(() => {
    initButtonAnimations();
}, 50);

// After adding cart items
animateCartItems();
```

---

## Performance Tips

1. **Use GPU acceleration**: Use `transform` and `opacity`

    ```javascript
    gsap.to(element, {
        transform: "translateX(100px)", // Good
        x: 100, // Also good (GSAP optimizes)
        left: "100px", // Slower
    });
    ```

2. **Limit stagger delay**: Keep stagger under 0.2s

    ```javascript
    // Good
    gsap.staggerTo(".item", 0.3, { y: -10 }, 0.05);

    // Too slow
    gsap.staggerTo(".item", 0.3, { y: -10 }, 0.5);
    ```

3. **Use `will-change` CSS**: For complex animations

    ```css
    .animated-element {
        will-change: transform, opacity;
    }
    ```

4. **Limit simultaneous animations**: Group related animations
    ```javascript
    gsap.to(".button", { scale: 1.1, duration: 0.2 });
    gsap.to(".icon", { rotate: 180, duration: 0.2 });
    ```

---

## Troubleshooting

### Animations not working?

1. Check browser console for errors
2. Verify GSAP is loaded: `console.log(gsap)`
3. Ensure element exists when animation triggers
4. Check if animations are being overridden by CSS

### Animation jerky or stuttering?

1. Reduce animation duration
2. Ensure you're animating `transform` not `left/top`
3. Check for heavy JavaScript on the same thread
4. Use `will-change` CSS property

### Animation conflicts?

Use `gsap.killTweensOf()` to stop existing animations:

```javascript
gsap.killTweensOf(element);
gsap.to(element, {
    /* new animation */
});
```

---

## Resources

- **GSAP Docs**: https://greensock.com/docs/v3/GSAP
- **Easing Visualizer**: https://greensock.com/ease-visualizer
- **Learning**: https://greensock.com/learning

---

## Summary

The animation system is:

- ✅ Fully modular and organized
- ✅ Auto-initialized on page load
- ✅ Performance optimized
- ✅ Easy to extend with new animations
- ✅ Compatible with Livewire
- ✅ Touch-friendly for mobile
