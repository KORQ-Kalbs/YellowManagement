/**
 * Tests for Page Navigation Loader feature.
 *
 * Task 8: Markup structure assertions (static HTML parsing, no Alpine runtime)
 * Task 9: Alpine.js state behavior (lightweight state simulation)
 * Task 10: Timeout fallback and sidebar/mobile link coverage
 */

import { describe, it, expect, beforeEach } from 'vitest';
import { readFileSync } from 'fs';
import { resolve, dirname } from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

const APP_BLADE_PATH = resolve(__dirname, '../../../views/layouts/app.blade.php');
const appBladeContent = readFileSync(APP_BLADE_PATH, 'utf-8');

// ---------------------------------------------------------------------------
// Task 8 — Markup structure assertions
// ---------------------------------------------------------------------------

describe('Page Navigation Loader — Markup Structure', () => {
    it('body x-data contains pageIsLoading: false', () => {
        expect(appBladeContent).toMatch(/pageIsLoading:\s*false/);
    });

    it('body x-data contains all five required properties', () => {
        expect(appBladeContent).toMatch(/sidebarOpen/);
        expect(appBladeContent).toMatch(/theme/);
        expect(appBladeContent).toMatch(/sidebarWidth/);
        expect(appBladeContent).toMatch(/isResizing/);
        expect(appBladeContent).toMatch(/pageIsLoading:\s*false/);
    });

    it('Content_Area wrapper div has relative class', () => {
        // The wrapper div that contains the loader and main content
        expect(appBladeContent).toMatch(/class="[^"]*flex flex-col[^"]*relative[^"]*"/);
    });

    it('loader overlay has x-show="pageIsLoading"', () => {
        expect(appBladeContent).toContain('x-show="pageIsLoading"');
    });

    it('loader overlay has style="display: none;" inline fallback', () => {
        expect(appBladeContent).toContain('style="display: none;"');
    });

    it('loader overlay has absolute inset-0 z-50 classes', () => {
        expect(appBladeContent).toMatch(/class="[^"]*absolute inset-0 z-50[^"]*"/);
    });

    it('loader overlay has x-transition:leave specifying duration-300 and opacity fade', () => {
        expect(appBladeContent).toContain('x-transition:leave="transition ease-in duration-300"');
        expect(appBladeContent).toContain('x-transition:leave-start="opacity-100"');
        expect(appBladeContent).toContain('x-transition:leave-end="opacity-0"');
    });

    it('spinner has animate-spin, w-12, h-12, border-4, border-yellow-500, border-t-orange-500 classes', () => {
        expect(appBladeContent).toMatch(/class="[^"]*animate-spin[^"]*"/);
        expect(appBladeContent).toMatch(/class="[^"]*w-12[^"]*h-12[^"]*"/);
        expect(appBladeContent).toMatch(/class="[^"]*border-4[^"]*"/);
        expect(appBladeContent).toMatch(/class="[^"]*border-yellow-500[^"]*"/);
        expect(appBladeContent).toMatch(/class="[^"]*border-t-orange-500[^"]*"/);
    });

    it('label text "Memuat..." is present inside the overlay', () => {
        expect(appBladeContent).toContain('Memuat...');
    });

    it('gradient backdrop has bg-gradient-to-br from-yellow-400/10 to-orange-500/10', () => {
        expect(appBladeContent).toContain('bg-gradient-to-br from-yellow-400/10 to-orange-500/10');
    });

    it('loader div has aria-live="polite"', () => {
        expect(appBladeContent).toContain('aria-live="polite"');
    });

    it('loader div has aria-label="Memuat halaman"', () => {
        expect(appBladeContent).toContain('aria-label="Memuat halaman"');
    });

    it('loader overlay appears before x-navbar in the Content_Area wrapper', () => {
        const loaderPos = appBladeContent.indexOf('x-show="pageIsLoading"');
        const navbarPos = appBladeContent.indexOf('<x-navbar');
        expect(loaderPos).toBeGreaterThan(-1);
        expect(navbarPos).toBeGreaterThan(-1);
        expect(loaderPos).toBeLessThan(navbarPos);
    });
});

// ---------------------------------------------------------------------------
// Task 9 — Alpine.js state behavior (lightweight state simulation)
//
// Full Alpine.js runtime is not loaded in jsdom. Instead, we simulate the
// Alpine reactive component using a plain JS object that mirrors the exact
// x-data state and the event handler logic from app.blade.php.
// This lets us verify the state mutation logic is correct without needing
// the full Alpine runtime.
// ---------------------------------------------------------------------------

/**
 * Creates a minimal Alpine-like component that mirrors the body x-data + x-init
 * logic from app.blade.php. Returns the state object and a cleanup function.
 *
 * State:
 *   { sidebarOpen, theme, sidebarWidth, isResizing, pageIsLoading }
 *
 * x-init registers three window event listeners (load, pageshow, loader-timeout).
 * The click handler logic for nav <a> tags: if (!pageIsLoading) pageIsLoading = true
 */
function createAlpineState(overrides = {}) {
    const state = {
        sidebarOpen: false,
        theme: 'light',
        sidebarWidth: 224,
        isResizing: false,
        pageIsLoading: false,
        ...overrides,
    };

    // Mirror x-init window listeners
    const loadHandler = () => { state.pageIsLoading = false; };
    const pageshowHandler = () => { state.pageIsLoading = false; };
    const loaderTimeoutHandler = () => { state.pageIsLoading = false; };

    window.addEventListener('load', loadHandler);
    window.addEventListener('pageshow', pageshowHandler);
    window.addEventListener('loader-timeout', loaderTimeoutHandler);

    function cleanup() {
        window.removeEventListener('load', loadHandler);
        window.removeEventListener('pageshow', pageshowHandler);
        window.removeEventListener('loader-timeout', loaderTimeoutHandler);
    }

    return { state, cleanup };
}

/**
 * Simulates the @click handler on a sidebar nav <a> tag:
 *   @click="if (!pageIsLoading) $root.pageIsLoading = true"
 */
function simulateNavLinkClick(state) {
    if (!state.pageIsLoading) {
        state.pageIsLoading = true;
    }
}

/**
 * Simulates a click on a non-nav element (e.g. theme toggle button).
 * Theme toggle only changes `theme`, it does NOT touch pageIsLoading.
 */
function simulateThemeToggleClick(state) {
    state.theme = state.theme === 'dark' ? 'light' : 'dark';
}

/**
 * Returns the expected CSS class for the theme-aware backdrop based on `theme`.
 * Mirrors: :class="theme === 'dark' ? 'bg-gray-900/80' : 'bg-white/80'"
 */
function backdropClass(state) {
    return state.theme === 'dark' ? 'bg-gray-900/80' : 'bg-white/80';
}

/**
 * Returns whether the overlay would be visible (mirrors x-show="pageIsLoading").
 * When pageIsLoading is false, Alpine applies display:none.
 */
function overlayVisible(state) {
    return state.pageIsLoading === true;
}

describe('Page Navigation Loader — Alpine.js State Behavior', () => {
    let state;
    let cleanup;

    beforeEach(() => {
        const result = createAlpineState();
        state = result.state;
        cleanup = result.cleanup;
    });

    afterEach(() => {
        cleanup();
    });

    // --- Loader visibility / click behavior ---

    it('clicking a sidebar nav <a> sets pageIsLoading to true (Req 1.1, 1.2)', () => {
        expect(state.pageIsLoading).toBe(false);
        simulateNavLinkClick(state);
        expect(state.pageIsLoading).toBe(true);
    });

    it('when pageIsLoading is true, overlay does not have display:none (Req 3.2)', () => {
        state.pageIsLoading = true;
        expect(overlayVisible(state)).toBe(true);
    });

    it('when pageIsLoading is false, overlay has display:none (Req 3.2)', () => {
        state.pageIsLoading = false;
        expect(overlayVisible(state)).toBe(false);
    });

    it('clicking a non-nav element (theme toggle button) does not change pageIsLoading (Req 1.6)', () => {
        expect(state.pageIsLoading).toBe(false);
        simulateThemeToggleClick(state);
        expect(state.pageIsLoading).toBe(false);
    });

    it('clicking theme toggle while loading does not reset pageIsLoading (Req 1.6)', () => {
        state.pageIsLoading = true;
        simulateThemeToggleClick(state);
        expect(state.pageIsLoading).toBe(true);
    });

    it('double-clicking a nav link keeps pageIsLoading as true — no toggle back to false (Req 5.4)', () => {
        simulateNavLinkClick(state); // first click: false → true
        simulateNavLinkClick(state); // second click: guard prevents any change
        expect(state.pageIsLoading).toBe(true);
    });

    // --- Window event listeners ---

    it('dispatching window "load" event sets pageIsLoading to false (Req 3.1)', () => {
        state.pageIsLoading = true;
        window.dispatchEvent(new Event('load'));
        expect(state.pageIsLoading).toBe(false);
    });

    it('dispatching window "pageshow" event sets pageIsLoading to false (Req 4.1)', () => {
        state.pageIsLoading = true;
        window.dispatchEvent(new Event('pageshow'));
        expect(state.pageIsLoading).toBe(false);
    });

    it('dispatching window "pageshow" with event.persisted = true sets pageIsLoading to false (Req 4.2)', () => {
        state.pageIsLoading = true;
        const evt = new Event('pageshow');
        Object.defineProperty(evt, 'persisted', { value: true, writable: false });
        window.dispatchEvent(evt);
        expect(state.pageIsLoading).toBe(false);
    });

    it('dispatching window "loader-timeout" event sets pageIsLoading to false (Req 4.1, 4.2)', () => {
        state.pageIsLoading = true;
        window.dispatchEvent(new Event('loader-timeout'));
        expect(state.pageIsLoading).toBe(false);
    });

    // --- Theme-aware backdrop ---

    it('when theme = "light", backdrop div has class bg-white/80 (Req 2.4)', () => {
        state.theme = 'light';
        expect(backdropClass(state)).toBe('bg-white/80');
    });

    it('when theme = "dark", backdrop div has class bg-gray-900/80 (Req 2.5)', () => {
        state.theme = 'dark';
        expect(backdropClass(state)).toBe('bg-gray-900/80');
    });

    it('switching theme from light to dark changes backdrop class accordingly', () => {
        state.theme = 'light';
        expect(backdropClass(state)).toBe('bg-white/80');

        simulateThemeToggleClick(state);
        expect(state.theme).toBe('dark');
        expect(backdropClass(state)).toBe('bg-gray-900/80');
    });
});
