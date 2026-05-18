{{-- Laravel Control Terminal Component --}}
{{-- Usage: @include('components.laravel-control-terminal') --}}

<style>
:root {
    /* Layout dimensions */
    --lc-graph-w: 395px;
    --lc-terminal-h: 200px;
    --lc-sidebar-w: 256px;  /* Adjust to match your sidebar width */
    --lc-navbar-h: 61px;    /* Adjust to match your navbar height */

    /* ===== Light Mode Colors (Default) ===== */
    --lc-bg-primary: #ffffff;
    --lc-bg-secondary: #f5f5f5;
    --lc-bg-tertiary: #e8e8e8;
    --lc-bg-input: #ffffff;
    --lc-text-primary: #1a1a1a;
    --lc-text-secondary: #666666;
    --lc-text-muted: #999999;
    --lc-border-color: #e0e0e0;
    --lc-border-light: rgba(0,0,0,.1);
    --lc-scrollbar-track: #f0f0f0;
    --lc-scrollbar-thumb: #c0c0c0;
    --lc-hover-bg: rgba(0,0,0,.05);
    --lc-active-bg: rgba(0,0,0,.08);

    /* Terminal specific */
    --lc-terminal-cmd: #0066cc;
    --lc-terminal-success: #28a745;
    --lc-terminal-error: #dc3545;
    --lc-terminal-info: #856404;

    /* Pipeline specific */
    --lc-pipeline-card-bg: #f8f9fa;
    --lc-pipeline-card-border: #dee2e6;
    --lc-stage-pending-bg: #e9ecef;
    --lc-stage-pending-border: #adb5bd;
    --lc-tooltip-bg: #ffffff;
    --lc-tooltip-border: #dee2e6;
    --lc-tooltip-header-bg: #f8f9fa;

    /* Tree/Branch specific */
    --lc-tree-line: #9f9f9f;
    --lc-branch-tag-bg: #28a745;
}

/* ===== Dark Mode Colors ===== */
html.dark, body.dark {
    --lc-bg-primary: #0f0f10;
    --lc-bg-secondary: #1a1a1b;
    --lc-bg-tertiary: #252526;
    --lc-bg-input: #1a1a1b;
    --lc-text-primary: #eaeaea;
    /* --lc-text-secondary: #888888; */
    --lc-text-secondary: #c2c2c2;
    --lc-text-muted: #666666;
    --lc-border-color: rgba(255,255,255,.15);
    --lc-border-light: rgba(255,255,255,.1);
    --lc-scrollbar-track: #1a1a1b;
    --lc-scrollbar-thumb: #3a3a3b;
    --lc-hover-bg: rgba(255,255,255,.08);
    --lc-active-bg: rgba(128, 128, 128, 0.3);

    /* Terminal specific */
    --lc-terminal-cmd: #4fc3f7;
    --lc-terminal-success: #81c784;
    --lc-terminal-error: #e57373;
    --lc-terminal-info: #fff176;

    /* Pipeline specific */
    --lc-pipeline-card-bg: #2d2d30;
    --lc-pipeline-card-border: #3e3e42;
    --lc-stage-pending-bg: #2d2d30;
    --lc-stage-pending-border: #484f58;
    --lc-tooltip-bg: #1e1e1e;
    --lc-tooltip-border: #3e3e42;
    --lc-tooltip-header-bg: #252526;

    /* Tree/Branch specific */
    --lc-tree-line: #9f9f9f;
    --lc-branch-tag-bg: #00a55b;
}

/* ===== Combined Panel (Left Sidebar) ===== */
.lc-panel {
    position: fixed;
    top: var(--lc-navbar-h);
    left: var(--lc-sidebar-w);
    width: var(--lc-sidebar-w);
    height: calc(100% - var(--lc-navbar-h));
    background: var(--lc-bg-primary);
    border-right: 1px solid var(--lc-border-color);
    z-index: 40;
    display: flex;
    flex-direction: column;
    transform: translateX(-100%);
    visibility: hidden;
    pointer-events: none;
    transition: transform .25s ease, visibility .25s ease, background .3s ease, color .3s ease, width .25s ease;
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
}

.lc-panel.is-open {
    transform: translateX(0);
    visibility: visible;
    pointer-events: auto;
}

/* Resizer on right edge */
.lc-panel-resizer {
    position: absolute;
    right: -4px;
    top: 0;
    width: 8px;
    height: 100%;
    cursor: ew-resize;
    z-index: 10;
}

/* ===== Terminal Panel (bottom half inside .lc-panel) ===== */
.lc-terminal {
    height: var(--lc-terminal-h);
    background: var(--lc-bg-primary);
    color: var(--lc-text-primary);
    border-top: 1px solid var(--lc-border-color);
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
    font-family: inherit;
}

.lc-terminal-header {
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 12px;
    background: var(--lc-bg-secondary);
    border-bottom: 1px solid var(--lc-border-light);
    user-select: none;
    flex-shrink: 0;
}

.lc-terminal-header-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.lc-terminal-title {
    font-weight: 600;
    font-size: 13px;
    display: flex;
    align-items: center;
    color: var(--lc-text-primary);
}

.lc-terminal-shortcut {
    opacity: .6;
    font-size: 11px;
    background: var(--lc-hover-bg);
    padding: 2px 6px;
    border-radius: 4px;
}

.lc-terminal-header-right {
    display: flex;
    gap: 8px;
}

.lc-terminal-resizer {
    width: 100%;
    height: 6px;
    cursor: ns-resize;
    z-index: 10;
    flex-shrink: 0;
    background: transparent;
}
.lc-terminal-resizer:hover {
    background: var(--lc-border-color);
}

.lc-terminal-body {
    flex: 1;
    overflow-y: auto;
    padding: 10px 12px;
    font-size: 13px;
    line-height: 1.5;
}

.lc-terminal-body::-webkit-scrollbar { width: 8px; }
.lc-terminal-body::-webkit-scrollbar-track { background: var(--lc-scrollbar-track); }
.lc-terminal-body::-webkit-scrollbar-thumb { background: var(--lc-scrollbar-thumb); border-radius: 4px; }

.lc-terminal-line { white-space: pre-wrap; word-break: break-word; }
.lc-terminal-line.cmd { color: var(--lc-terminal-cmd); }
.lc-terminal-line.success { color: var(--lc-terminal-success); }
.lc-terminal-line.error { color: var(--lc-terminal-error); }
.lc-terminal-line.info { color: var(--lc-terminal-info); }
.lc-terminal-line.muted { color: var(--lc-text-muted); }

.lc-branch-line { display: flex; align-items: center; padding: 2px 0; }
.lc-branch-current { color: var(--lc-terminal-success); font-weight: 600; }
.lc-branch-marker { color: var(--lc-terminal-success); margin-right: 4px; }

.lc-terminal-input-wrap {
    border-top: 1px solid var(--lc-border-light);
    padding: 5px 5px;
    display: flex;
    gap: 8px;
    background: var(--lc-bg-primary);
    flex-shrink: 0;
}

.lc-terminal-input {
    flex: 1;
    background: var(--lc-bg-input);
    border: 1px solid var(--lc-border-color);
    color: var(--lc-text-primary);
    border-radius: 6px;
    padding: 2px 10px;
    outline: none;
    font-family: inherit;
    font-size: 13px;
}

.lc-terminal-input:focus { border-color: rgba(79, 195, 247, .5); }
.lc-terminal-input::placeholder { color: var(--lc-text-muted); }

.lc-btn {
    border: 1px solid var(--lc-border-color);
    background: transparent;
    color: var(--lc-text-primary);
    border-radius: 4px;
    padding: 3px 5px;
    cursor: pointer;
    font-size: 12px;
    transition: background .15s, border-color .15s, color .3s;
}

.lc-btn:hover {
    background: var(--lc-hover-bg);
    border-color: var(--lc-text-secondary);
}

.lc-btn.active {
    background: var(--lc-active-bg);
    border-color: var(--lc-text-primary);
}

/* ===== Laravel Graph Panel (top portion inside .lc-panel) ===== */
.lc-graph {
    flex: 1;
    min-height: 0;
    background: var(--lc-bg-secondary);
    color: var(--lc-text-primary);
    display: flex;
    flex-direction: column;
    font-family: inherit;
    overflow: hidden;
}

.lc-graph-header {
    display: flex;
    flex-direction: column;
    background: var(--lc-bg-tertiary);
    border-bottom: 1px solid var(--lc-border-light);
    user-select: none;
    flex-shrink: 0;
}

.lc-graph-header-top {
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 10px;
}

.lc-graph-title {
    font-weight: 600;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--lc-text-secondary);
    display: flex;
    align-items: center;
    gap: 6px;
}

.lc-graph-title-icon {
    flex-shrink: 0;
}

.lc-graph-controls {
    display: flex;
    gap: 4px;
}

.lc-graph-btn {
    width: 22px;
    height: 22px;
    border: none;
    background: transparent;
    color: var(--lc-text-secondary);
    cursor: pointer;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    transition: background .15s, color .15s;
}

.lc-graph-btn:hover {
    background: var(--lc-hover-bg);
    color: var(--lc-text-primary);
}

.lc-graph-search {
    padding: 2px 2px;
    border-bottom: 1px solid var(--lc-border-light);
}

.lc-graph-search input {
    width: 100%;
    background: var(--lc-bg-input);
    border: 1px solid var(--lc-border-color);
    color: var(--lc-text-primary);
    padding: 6px 10px;
    border-radius: 4px;
    font-size: 12px;
    outline: none;
}

.lc-graph-search input:focus {
    border-color: rgba(79, 195, 247, .5);
}

.lc-graph-search input::placeholder { color: var(--lc-text-muted); }

.lc-graph-body {
    flex: 1;
    overflow: auto;
    font-size: 12px;
}

.lc-graph-body::-webkit-scrollbar { width: 8px; }
.lc-graph-body::-webkit-scrollbar-track { background: var(--lc-scrollbar-track); }
.lc-graph-body::-webkit-scrollbar-thumb { background: var(--lc-scrollbar-thumb); border-radius: 4px; }

.lc-graph-resizer {
    display: none; /* Resizer now on .lc-panel-resizer */
    position: absolute;
    right: -4px;
    top: 0;
    width: 8px;
    height: 100%;
    cursor: ew-resize;
}

/* Expand button - hidden by default, show only in fullscreen */
.lc-graph-btn-expand {
    display: none !important;
}

.lc-panel.is-fullscreen .lc-graph-btn-expand {
    display: flex !important;
    align-items: center;
    gap: 4px;
    background: var(--lc-hover-bg) !important;
    padding: 2px 8px !important;
    width: auto !important;
    font-size: 11px !important;
}

.lc-panel.is-fullscreen .lc-graph-btn-expand:hover {
    background: rgba(255,255,255,0.15) !important;
}

/* Expanded = ทับ sidebar เต็มจอ */
.lc-panel.is-fullscreen.is-expanded {
    left: 0;
    width: 100%;
}

/* Float mode = draggable resizable window */
.lc-panel.is-floating {
    top: 80px;
    left: calc(50% - 200px);
    width: 400px;
    height: 500px;
    border-radius: 8px;
    border: 1px solid var(--lc-border-color);
    box-shadow: 0 8px 32px rgba(0,0,0,.45), 0 2px 8px rgba(0,0,0,.25);
    z-index: 9999;
    overflow: hidden;
    min-width: 300px;
    min-height: 250px;
}

.lc-panel.is-floating .lc-graph-header {
    cursor: move;
}

.lc-panel.is-floating .lc-graph-header .lc-graph-btn,
.lc-panel.is-floating .lc-graph-header input {
    cursor: default;
}

.lc-panel.is-floating .lc-terminal {
    flex: 0 0 auto;
    max-height: 40%;
    border-top: 1px solid var(--lc-border-color);
}

/* Edge resize handles */
.lc-float-edge {
    position: absolute;
    display: none;
    z-index: 10;
}
.lc-panel.is-floating .lc-float-edge { display: block; }

.lc-float-edge.top    { top: -4px;    left: 8px;   right: 8px;  height: 8px; cursor: n-resize; }
.lc-float-edge.bottom { bottom: -4px; left: 8px;   right: 8px;  height: 8px; cursor: s-resize; }
.lc-float-edge.left   { left: -4px;   top: 8px;    bottom: 8px; width: 8px;  cursor: w-resize; }
.lc-float-edge.right  { right: -4px;  top: 8px;    bottom: 8px; width: 8px;  cursor: e-resize; }
.lc-float-edge.top-left     { top: -4px;    left: -4px;   width: 12px; height: 12px; cursor: nw-resize; }
.lc-float-edge.top-right    { top: -4px;    right: -4px;  width: 12px; height: 12px; cursor: ne-resize; }
.lc-float-edge.bottom-left  { bottom: -4px; left: -4px;   width: 12px; height: 12px; cursor: sw-resize; }
.lc-float-edge.bottom-right { bottom: -4px; right: -4px;  width: 12px; height: 12px; cursor: se-resize; }

/* Git Graph Tree Structure */
.lc-tree {
    padding: 4px 0;
    position: relative;
}

/* Main vertical line — height set by JS via --main-line-h */
.lc-tree::before {
    content: '';
    position: absolute;
    left: 16px;
    top: 14px;
    width: 2px;
    background: var(--lc-tree-line);
    z-index: 0;
    height: var(--main-line-h, 0px);
    transition: height .25s ease;
}

/* Brand Group (Level 1) */
.lc-tree-brand {
    position: relative;
    padding-bottom: 4px;
}

.lc-tree-brand-header {
    display: flex;
    align-items: center;
    padding: 6px 10px;
    cursor: pointer;
    transition: background .1s;
    position: relative;
    z-index: 1;
}

.lc-tree-brand-header:hover {
    background: var(--lc-hover-bg);
}

/* Brand node circle */
.lc-tree-brand-node {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: var(--brand-color, #4fc3f7);
    margin-right: 10px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 9px;
    color: #000;
    font-weight: bold;
    position: relative;
    z-index: 2;
}

.lc-tree-brand-name {
    font-weight: 600;
    font-size: 12px;
    color: var(--lc-text-primary);
}

.lc-tree-brand-count {
    margin-left: 8px;
    font-size: 10px;
    color: var(--lc-text-secondary);
    background: var(--lc-hover-bg);
    padding: 1px 6px;
    border-radius: 10px;
}

.lc-tree-brand-toggle {
    margin-left: auto;
    color: var(--lc-text-secondary);
    font-size: 10px;
    transition: transform .2s;
}

.lc-tree-brand.is-collapsed .lc-tree-brand-toggle {
    transform: rotate(-90deg);
}

/* Branch items container (Level 2) */
.lc-tree-branches {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin: 2px 10px 8px 10px;
    padding-left: 28px;
    overflow: hidden;
    transition: max-height .25s ease;
    position: relative;
}

.lc-tree-brand.is-collapsed .lc-tree-branches {
    max-height: 0 !important;
    margin: 0 10px 0 10px;
}

/* Each branch item - inline style like Git Graph */
.lc-tree-branch {
    display: inline-flex;
    align-items: center;
    padding: 0px 7px;
    margin: 0px 0 2px 0;
    cursor: pointer;
    transition: background .1s, border-color .1s;
    position: relative;
    border: 1px solid var(--brand-color, #4fc3f7);
    border-radius: 3px;
    background: transparent;
    white-space: nowrap;
}

/* Horizontal line from main vertical line to each branch box */
.lc-tree-branch::before {
    content: '';
    position: absolute;
    left: -23px;
    top: 50%;
    width: 22px;
    height: 2px;
    background: var(--lc-tree-line);
}

.lc-tree-branch:hover {
    background: var(--lc-hover-bg);
}

.lc-tree-branch.is-current {
    background: rgba(0, 165, 91, .25);
    border-color: #00a55b;
}

.lc-tree-branch.is-current::before {
    background: #00a55b;
}

/* Branch icon (Git branch style) */
.lc-tree-branch-icon {
    width: 12px;
    height: 12px;
    margin-right: 4px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--brand-color, #4fc3f7);
}

.lc-tree-branch-icon svg {
    width: 12px;
    height: 12px;
    fill: currentColor;
}

.lc-tree-branch.is-current .lc-tree-branch-icon {
    color: #00a55b;
}

.lc-tree-branch-name {
    font-size: 11px;
    color: var(--lc-text-secondary);
}

.lc-tree-branch.is-current .lc-tree-branch-name {
    color: var(--lc-text-primary);
    font-weight: 600;
}

.lc-tree-branch-tag {
    margin-left: 6px;
    font-size: 9px;
    padding: 1px 4px;
    border-radius: 2px;
    background: #00a55b;
    color: #fff;
    font-weight: 600;
}

/* ===== Children (sub-routes under a branch) ===== */
.lc-tree-children {
    display: none;
    flex-direction: column;
    margin: 2px 0 4px 0;
    padding-left: 20px;
    position: relative;
}

.lc-tree-children.is-expanded {
    display: flex;
}

/* Vertical line for children — height set by JS via --line-h */
.lc-tree-children::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 0;
    width: 2px;
    background: #888;
    height: var(--line-h, 0px);
}

.lc-tree-child {
    display: inline-flex;
    align-items: center;
    padding: 2px 8px;
    margin: 2px 0;
    cursor: pointer;
    font-size: 11px;
    color: var(--lc-text-secondary);
    border: 1px solid var(--brand-color, #81c784);
    border-radius: 3px;
    transition: all .2s;
    position: relative;
    white-space: nowrap;
}

/* Horizontal connector from vertical line to child */
.lc-tree-child::before {
    content: '';
    position: absolute;
    left: -13px;
    top: 50%;
    width: 12px;
    height: 2px;
    background: #888;
}

.lc-tree-child:hover {
    background: var(--lc-hover-bg);
    border-color: var(--lc-text-secondary);
}

.lc-tree-child-name {
    font-size: 11px;
}

.lc-tree-child-status {
    width: 14px;
    height: 14px;
    margin-left: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    flex-shrink: 0;
    font-weight: 700;
}

/* Testing state - blinking pulse */
/* ===== Trail animation: dot travels from parent branch down to child ===== */
/* CSS names: .lc-trail-source, .lc-trail-pulse, .lc-trail-target, .lc-trail-dot */

/* The dot that travels */
.lc-trail-dot {
    position: absolute;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #00a55b;
    box-shadow: 0 0 6px rgba(0,165,91,.7), 0 0 12px rgba(0,165,91,.3);
    z-index: 10;
    pointer-events: none;
    opacity: 0;
}

/* Branch glow when trail starts */
.lc-tree-branch.lc-trail-source {
    background: rgba(0,165,91,.25);
    border-color: #00a55b;
    transition: all .3s;
}

@keyframes test-blink {
    0%, 100% { background: rgba(0,165,91,.25); border-color: #00a55b; box-shadow: 0 0 4px rgba(0,165,91,.4); }
    50% { background: rgba(0,165,91,.08); border-color: rgba(0,165,91,.3); box-shadow: 0 0 8px rgba(0,165,91,.6); }
}

.lc-tree-child.is-testing {
    border-color: #00a55b;
    background: rgba(0,165,91,.25);
    animation: test-blink 1s ease-in-out infinite;
}

.lc-tree-child.is-testing .lc-tree-child-name {
    color: var(--lc-text-primary);
    font-weight: 600;
}

/* GitLab pie loader — progress driven by --progress (0-360deg) */
.gitlab-pie-loader {
    width: 18px;
    height: 18px;
    display: none;
    position: relative;
    border-radius: 50%;
    border: 2px solid #3f8fc9;
    background: #d9edf9;
    margin-left: 6px;
    flex-shrink: 0;
    --progress: 0deg;
}
.gitlab-pie-loader::before {
    content: "";
    position: absolute;
    inset: 2px;
    border-radius: 50%;
    background:
        conic-gradient(
            from -90deg,
            #2f80bf 0deg var(--progress),
            #d9edf9 var(--progress) 360deg
        );
}
.lc-tree-child.is-testing .gitlab-pie-loader {
    display: inline-block;
}
.lc-tree-child.is-testing .lc-test-result {
    display: none;
}

/* Passed state */
.lc-tree-child.is-passed {
    border-color: #00a55b;
    background: rgba(0,165,91,.12);
}

.lc-tree-child.is-passed .lc-tree-child-status {
    color: #00a55b;
}

/* Failed state */
.lc-tree-child.is-failed {
    border-color: #e51400;
    background: rgba(229,20,0,.12);
}

.lc-tree-child.is-failed .lc-tree-child-status {
    color: #e51400;
}

/* Tree child line connector (├─) */
.lc-tree-child-line {
    font-family: monospace;
    font-size: 11px;
    color: var(--brand-color, #4fc3f7);
    opacity: 0.5;
    margin-right: 4px;
    user-select: none;
}

/* Test result icon (✓ / ✕) — hidden; replaced by lc-child-status-label */
.lc-test-result { display: none !important; }

/* Status label next to child name (running / passed / failed) */
.lc-child-status-label {
    margin-left: auto;
    font-size: 9px;
    font-weight: 700;
    flex-shrink: 0;
    letter-spacing: 0.02em;
}
.lc-tree-child.is-testing .lc-child-status-label::before { content: 'running';  color: #3b82f6; }
.lc-tree-child.is-passed  .lc-child-status-label::before { content: '✓ passed'; color: #00a55b; }
.lc-tree-child.is-failed  .lc-child-status-label::before { content: '✕ failed'; color: #e51400; }

/* ===== Stages: GitLab-style step circles ===== */
.lc-stages-wrap {
    padding-left: 22px;
}

.lc-stages-toggle {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    font-size: 10px;
    color: var(--lc-text-secondary);
    cursor: pointer;
    user-select: none;
    padding: 1px 0;
    opacity: 0;
    pointer-events: none;
    transition: opacity .2s;
}

.lc-stages-wrap.has-results .lc-stages-toggle {
    opacity: 1;
    pointer-events: auto;
}

.lc-stages-toggle:hover {
    color: var(--lc-text-primary, #fff);
}

.lc-stages-toggle-arrow {
    display: inline-flex;
    width: 12px;
    height: 12px;
    align-items: center;
    justify-content: center;
    transition: transform .25s ease;
    font-size: 10px;
}

.lc-stages-wrap.is-expanded .lc-stages-toggle-arrow {
    transform: rotate(180deg);
}

.lc-stages {
    display: none;
    flex-wrap: wrap;
    gap: 6px 48px;
    padding: 6px 0 4px 0;
    width: 180px;
}

.lc-stages-wrap.is-expanded .lc-stages {
    display: flex;
}

.lc-stage {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 2px solid #555;
    background: transparent;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    color: #888;
    transition: all .3s;
    cursor: default;
    position: relative;
}

.lc-stage.is-passed {
    border-color: #238636;
    background: #238636;
    color: #fff;
}

.lc-stage.is-failed {
    border-color: #da3633;
    background: #da3633;
    color: #fff;
}

/* Percentage badge next to Stages toggle */
.lc-stages-percent {
    font-size: 10px;
    font-weight: 600;
    color: #3fb950;
    margin-left: 2px;
}

.lc-stages .lc-stage-tooltip {
    display: none;
    position: absolute;
    bottom: calc(100% + 8px);
    top: auto;
    left: 50%;
    transform: translateX(-50%);
    font-size: 11px;
    font-weight: 500;
    padding: 5px 10px;
    border-radius: 4px;
    white-space: nowrap;
    z-index: 9999;
    pointer-events: none;
    line-height: 1.5;
    text-align: center;
    max-width: 220px;
    min-width: auto;
    background: #333 !important;
    color: #e0e0e0 !important;
    border: 1px solid #555 !important;
    box-shadow: 0 2px 8px rgba(0,0,0,.5);
}

.lc-stages .lc-stage-tooltip::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    border: 5px solid transparent;
    border-top-color: #333;
}

.lc-stages .lc-stage:hover .lc-stage-tooltip {
    display: block;
}

/* Connecting lines between stage circles — use ::after going RIGHT */
.lc-stage:not(:nth-child(3n))::after {
    content: '';
    position: absolute;
    left: 100%;
    top: 50%;
    width: 48px;
    height: 2px;
    background: #555;
    transform: translateY(-50%);
}
/* Hide line on last circle (no next circle to connect to) */
.lc-stage:last-child::after {
    display: none;
}

/* Green line between two passed circles */
.lc-stage.is-passed:not(:nth-child(3n))::after {
    background: #238636;
}
/* Red line when either side is failed */
.lc-stage.is-failed:not(:nth-child(3n))::after {
    background: #da3633;
}

/* ===== Automated Test: Green Glass Overlay ===== */
.lc-test-overlay {
    position: absolute;
    inset: -4px;
    border-radius: 8px;
    background: rgba(0, 180, 80, 0.12);
    border: 2px solid rgba(0, 180, 80, 0.6);
    box-shadow: 0 0 12px rgba(0, 180, 80, 0.3), inset 0 0 8px rgba(0, 180, 80, 0.08);
    z-index: 9998;
    pointer-events: none;
    animation: lc-glass-blink 1.2s ease-in-out infinite;
}

.lc-test-overlay-label {
    position: absolute;
    top: 2px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0, 180, 80, 0.85);
    color: #fff;
    font-size: 10px;
    font-weight: 600;
    padding: 1px 8px;
    border-radius: 3px;
    white-space: nowrap;
    z-index: 9999;
    pointer-events: none;
}

@keyframes lc-glass-blink {
    0%, 100% {
        border-color: rgba(0, 180, 80, 0.6);
        box-shadow: 0 0 12px rgba(0, 180, 80, 0.3), inset 0 0 8px rgba(0, 180, 80, 0.08);
    }
    50% {
        border-color: rgba(0, 180, 80, 0.2);
        box-shadow: 0 0 20px rgba(0, 180, 80, 0.5), inset 0 0 12px rgba(0, 180, 80, 0.15);
    }
}

.lc-test-overlay.is-done {
    animation: none;
    border-color: rgba(0, 180, 80, 0.8);
    background: rgba(0, 180, 80, 0.18);
}

.lc-test-overlay.is-error {
    animation: none;
    border-color: rgba(229, 20, 0, 0.8);
    background: rgba(229, 20, 0, 0.15);
    box-shadow: 0 0 12px rgba(229, 20, 0, 0.3), inset 0 0 8px rgba(229, 20, 0, 0.08);
}

.lc-test-overlay.is-error .lc-test-overlay-label {
    background: rgba(229, 20, 0, 0.9);
}

/* Expand arrow on branches with children */
.lc-tree-branch-arrow {
    margin-left: auto;
    width: 16px;
    height: 16px;
    font-size: 10px;
    color: var(--lc-text-secondary);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: transform .50s ease;
}

.lc-tree-branch.is-expanded .lc-tree-branch-arrow {
    transform: rotate(180deg);
}

/* Brand colors */
.lc-tree-brand[data-color="green"] { --brand-color: #81c784; }
.lc-tree-brand[data-color="cyan"] { --brand-color: #4fc3f7; }
.lc-tree-brand[data-color="magenta"] { --brand-color: #ce93d8; }
/* .lc-tree-brand[data-color="yellow"] { --brand-color: #fae20c; } */
.lc-tree-brand[data-color="yellow"] { --brand-color: #ffbc05; }
.lc-tree-brand[data-color="red"] { --brand-color: #B21A1B; }
.lc-tree-brand[data-color="orange"] { --brand-color: #ffb74d; }
.lc-tree-brand[data-color="blue"] { --brand-color: #64b5f6; }
.lc-tree-brand[data-color="pink"] { --brand-color: #f48fb1; }

/* ===== Glow Animation for Role Switch ===== */
@keyframes glow-pulse {
    0%, 100% { box-shadow: 0 0 5px 2px rgba(0, 165, 91, 0.5); }
    50% { box-shadow: 0 0 20px 8px rgba(0, 165, 91, 0.9); }
}

@keyframes glow-travel {
    0% { left: 0; opacity: 1; }
    100% { left: 100%; opacity: 0; }
}

.lc-tree-branch.glow-from {
    animation: glow-pulse 0.6s ease-in-out;
    box-shadow: 0 0 15px 5px rgba(0, 165, 91, 0.8);
    z-index: 10;
}

.lc-tree-branch.glow-to {
    animation: glow-pulse 0.6s ease-in-out 0.5s;
    box-shadow: 0 0 20px 8px rgba(0, 165, 91, 1);
    border-color: #00a55b !important;
    z-index: 10;
}

/* Traveling glow dot */
.lc-glow-dot {
    position: absolute;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #00a55b;
    box-shadow: 0 0 10px 4px rgba(0, 165, 91, 0.9);
    pointer-events: none;
    z-index: 100;
}

/* Glow line path */
.lc-glow-path {
    position: absolute;
    height: 2px;
    background: linear-gradient(90deg, transparent, #00a55b, #00a55b, transparent);
    pointer-events: none;
    z-index: 50;
    opacity: 0;
    animation: line-glow 0.8s ease-out forwards;
}

@keyframes line-glow {
    0% { opacity: 0; }
    20% { opacity: 1; }
    80% { opacity: 1; }
    100% { opacity: 0; }
}

/* Empty state */
.lc-graph-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 200px;
    color: var(--lc-text-muted);
    font-size: 12px;
}

.lc-graph-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    color: var(--lc-text-secondary);
}

/* Text buttons for Show/Show All */
.lc-graph-btn-text {
    width: auto !important;
    padding: 2px 8px !important;
    font-size: 10px !important;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Show button - Green glow with white text */
.lc-graph-btn-show {
    background: rgba(0, 165, 91, 0.3) !important;
    border: 1px solid #00a55b !important;
    color: #fff !important;
    box-shadow: 0 0 8px rgba(0, 165, 91, 0.6), 0 0 15px rgba(0, 165, 91, 0.4);
    text-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
    animation: glow-green 2s ease-in-out infinite alternate;
}

.lc-graph-btn-show:hover {
    background: rgba(0, 165, 91, 0.5) !important;
    box-shadow: 0 0 12px rgba(0, 165, 91, 0.8), 0 0 25px rgba(0, 165, 91, 0.6);
}

/* Show All button - Blue glow with white text */
.lc-graph-btn-show-all {
    background: rgba(0, 120, 212, 0.3) !important;
    border: 1px solid #0078d4 !important;
    color: #fff !important;
    box-shadow: 0 0 8px rgba(0, 120, 212, 0.6), 0 0 15px rgba(0, 120, 212, 0.4);
    text-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
    animation: glow-blue 2s ease-in-out infinite alternate;
}

.lc-graph-btn-show-all:hover {
    background: rgba(0, 120, 212, 0.5) !important;
    box-shadow: 0 0 12px rgba(0, 120, 212, 0.8), 0 0 25px rgba(0, 120, 212, 0.6);
}

@keyframes glow-green {
    from {
        box-shadow: 0 0 5px rgba(0, 165, 91, 0.5), 0 0 10px rgba(0, 165, 91, 0.3);
    }
    to {
        box-shadow: 0 0 10px rgba(0, 165, 91, 0.8), 0 0 20px rgba(0, 165, 91, 0.5);
    }
}

@keyframes glow-blue {
    from {
        box-shadow: 0 0 5px rgba(0, 120, 212, 0.5), 0 0 10px rgba(0, 120, 212, 0.3);
    }
    to {
        box-shadow: 0 0 10px rgba(0, 120, 212, 0.8), 0 0 20px rgba(0, 120, 212, 0.5);
    }
}

/* ===== Laravel Graph Full Screen Mode ===== */
/* Fullscreen: expand .lc-panel to full width, hide terminal */
.lc-panel.is-fullscreen {
    width: calc(100% - var(--lc-sidebar-w));
    border-right: none;
}

.lc-panel.is-fullscreen .lc-terminal {
    display: none;
}

/* Hide search and footer in fullscreen mode */
.lc-panel.is-fullscreen .lc-graph-search,
.lc-panel.is-fullscreen .lc-graph-footer {
    display: none;
}

/* Hide title text in fullscreen, keep icon */
.lc-panel.is-fullscreen #lcGraphTitleText {
    display: none;
}

/* Fullscreen badge container (wraps icon + badge + HEAD) */
.lc-graph-fullscreen-badge {
    display: none;
    align-items: center;
    margin-left: 8px;
    padding: 2px 8px;
    border-radius: 3px;
    border: 1px solid #00a55b;
    background: rgba(0, 165, 91, .25);
}

.lc-panel.is-fullscreen .lc-graph-fullscreen-badge {
    display: inline-flex;
}

/* Branch icon inside container */
.lc-graph-branch-icon {
    display: inline-flex;
    width: 12px;
    height: 12px;
    flex-shrink: 0;
    align-items: center;
    justify-content: center;
    color: #00a55b;
    margin-right: 6px;
}

.lc-graph-branch-icon svg {
    width: 12px;
    height: 12px;
    fill: currentColor;
}

/* Badge text inside container */
.lc-graph-title-badge {
    font-size: 11px;
    color: var(--lc-text-primary);
}

/* HEAD tag inside container */
.lc-graph-head-tag {
    display: none;
    font-size: 9px;
    padding: 1px 4px;
    border-radius: 2px;
    background: #00a55b;
    color: #fff;
    font-weight: 600;
    margin-left: 6px;
}

/* Back button */
.lc-graph-btn-back {
    display: none;
    background: var(--lc-hover-bg) !important;
    padding: 2px 8px !important;
    width: auto !important;
    font-size: 11px !important;
}

.lc-panel.is-fullscreen .lc-graph-btn-back {
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Hide show buttons in fullscreen */
.lc-panel.is-fullscreen .lc-graph-btn-show,
.lc-panel.is-fullscreen .lc-graph-btn-show-all {
    display: none;
}

/* Commits view container */
.lc-graph-commits {
    display: none;
    flex-direction: column;
    flex: 1;
    width: 100%;
    min-height: 0;
}

.lc-panel.is-fullscreen .lc-graph-commits {
    display: flex !important;
}

.lc-panel.is-fullscreen .lc-graph-body {
    display: none;
}

.lc-panel.is-fullscreen .lc-tree,
.lc-panel.is-fullscreen .lc-graph-loading,
.lc-panel.is-fullscreen .lc-graph-empty {
    display: none !important;
}

.lc-show-body {
    flex: 1;
    overflow: auto;
    font-size: 12px;
}

.lc-show-body::-webkit-scrollbar { width: 8px; height: 8px; }
.lc-show-body::-webkit-scrollbar-track { background: var(--lc-scrollbar-track); }
.lc-show-body::-webkit-scrollbar-thumb { background: var(--lc-scrollbar-thumb); border-radius: 4px; }

/* Loading/Error/Empty states */
.lc-show-loading,
.lc-show-error,
.lc-show-empty {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    text-align: center;
}

/* ===== Payment Pipeline UI Styles (2-box layout - horizontal) ===== */
.lc-pipeline-row {
    display: grid;
    grid-template-columns: 1fr 100px;
    grid-template-rows: 1fr auto;
    gap: 10px;
    padding: 16px;
    position: relative;
    z-index: 1;
    background: var(--lc-pipeline-card-bg);
    border: 1px solid var(--lc-pipeline-card-border);
    border-radius: 8px;
    margin-bottom: 10px;
    min-height: calc(100vh - 280px);
}

/* Status left border */
.lc-pipeline-row.is-passed { border-left: 4px solid #00cc6a; }
.lc-pipeline-row.is-failed { border-left: 4px solid #e51400; }
.lc-pipeline-row.is-running { border-left: 4px solid #0078d4; }
.lc-pipeline-row.is-pending { border-left: 4px solid #ff8c00; }

/* Bottom row wrapper (info-user + info side by side) */
.lc-pipeline-bottom {
    grid-column: 1;
    grid-row: 2;
    display: flex;
    gap: 10px;
}

/* Box 0 - User info box (bottom-left) */
.lc-pipeline-info-user {
    flex: 1;
    background: var(--lc-hover-bg);
    border-radius: 6px;
    padding: 10px;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.lc-pipeline-user-header {
    display: flex;
    align-items: center;
    gap: 10px;
}

.lc-pipeline-user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: var(--lc-hover-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: var(--lc-text-primary);
    flex-shrink: 0;
}

.lc-pipeline-user-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--lc-text-primary);
}

.lc-pipeline-user-id {
    font-size: 11px;
    color: var(--lc-text-secondary);
}

.lc-pipeline-user-detail {
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    color: var(--lc-text-secondary);
    padding: 2px 0;
}

.lc-pipeline-user-detail span:last-child {
    color: var(--lc-text-primary);
    font-weight: 500;
}

/* Box 1 - Info box (bottom-right) */
.lc-pipeline-info {
    flex: 1;
    background: var(--lc-hover-bg);
    border-radius: 6px;
    padding: 10px;
}

.lc-pipeline-info-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
}

.lc-pipeline-status {
    font-size: 12px;
    padding: 2px 8px;
    border-radius: 10px;
    font-weight: 600;
    text-transform: uppercase;
}

.lc-pipeline-status.passed { background: rgba(0, 204, 106, .2); color: #00cc6a; }
.lc-pipeline-status.failed { background: rgba(229, 20, 0, .2); color: #e51400; }
.lc-pipeline-status.running { background: rgba(0, 120, 212, .2); color: #0078d4; }
.lc-pipeline-status.pending { background: rgba(255, 140, 0, .2); color: #ff8c00; }

.lc-pipeline-time {
    font-size: 11px;
    color: var(--lc-text-secondary);
    display: flex;
    align-items: center;
    gap: 4px;
}

.lc-pipeline-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--lc-text-primary);
    margin-bottom: 4px;
}

.lc-pipeline-meta {
    font-size: 11px;
    color: var(--lc-text-secondary);
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.lc-pipeline-tag {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 2px 6px;
    background: var(--lc-hover-bg);
    border-radius: 3px;
    font-size: 16px;
}

.lc-pipeline-tag-price {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 2px 6px;
    background: var(--lc-hover-bg);
    border-radius: 3px;
    font-size: 20px;
}

.lc-pipeline-tag.branch {
    background: rgba(0, 120, 212, .2);
    color: #4fc3f7;
}

.lc-pipeline-tag.member {
    background: rgba(0, 204, 106, .2);
    color: #00cc6a;
}

.lc-pipeline-tag-price.amount {
    background: rgba(255, 193, 7, .2);
    color: #ffc107;
    font-weight: 600;
}

/* Box 2 - DataTable container (top, stretches to fill) */
.lc-pipeline-table {
    grid-column: 1;
    grid-row: 1;
    padding: 8px 0;
    min-width: 0;
    display: flex;
    flex-direction: column;
    border-bottom: 1px solid var(--lc-pipeline-card-border);
    align-self: stretch;
}

.lc-pipeline-table-header {
    font-size: 18px;
    font-weight: 600;
    color: var(--lc-text-primary);
    padding-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.lc-pipeline-table-header .lc-table-subtitle {
    font-size: 14px;
    font-weight: 400;
    color: #ff8c00;
}

/* DataTable <table> */
.lc-datatable {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
    color: var(--lc-text-primary);
    flex: 1;
}

.lc-datatable thead th {
    font-size: 11px;
    font-weight: 600;
    color: var(--lc-text-secondary);
    text-transform: uppercase;
    text-align: left;
    padding: 8px 6px;
    border-bottom: 2px solid var(--lc-pipeline-card-border);
    white-space: nowrap;
}

.lc-datatable thead th.text-right { text-align: right; }
.lc-datatable thead th.text-center { text-align: center; }

.lc-datatable tbody td {
    padding: 8px 6px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    vertical-align: middle;
}

.lc-datatable tbody tr:last-child td {
    border-bottom: none;
}

.lc-datatable tbody tr:hover td {
    background: rgba(255,255,255,0.03);
}

.lc-datatable td.text-right { text-align: right; }
.lc-datatable td.text-center { text-align: center; }

.lc-datatable tfoot td {
    padding: 10px 6px;
    font-weight: 600;
    color: #ffc107;
    border-top: 2px solid var(--lc-pipeline-card-border);
}

.lc-datatable tfoot td.text-right { text-align: right; }
.lc-datatable tfoot td.text-center { text-align: center; }

/* DataTables wrapper overrides inside pipeline */
.lc-pipeline-table .dataTables_wrapper {
    color: var(--lc-text-primary);
    font-size: 13px;
}
.lc-pipeline-table .dataTables_wrapper .dataTables_info {
    font-size: 11px;
    color: var(--lc-text-secondary);
    padding: 6px 0;
}
.lc-pipeline-table .dataTables_wrapper .dataTables_scrollBody {
    flex: 1;
}

.lc-pipeline-table-tag {
    display: inline-flex;
    align-items: center;
    padding: 4px 12px;
    background: var(--lc-hover-bg);
    border-radius: 4px;
    font-size: 12px;
    color: var(--lc-text-secondary);
    margin-left: auto;
}

.lc-pipeline-table-tag.is-passed {
    background: rgba(0, 204, 106, .2);
    color: #00cc6a;
}

.lc-pipeline-table-tag.is-running {
    background: rgba(0, 120, 212, .2);
    color: #0078d4;
}

.lc-pipeline-table-tag.is-pending {
    background: rgba(255, 140, 0, .15);
    color: #ff8c00;
}

/* Stages (right side - vertical) */
.lc-pipeline-stages {
    grid-column: 2;
    grid-row: 1 / 3;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 4px;
    padding: 4px 0;
    overflow: hidden;
}

/* Stage group with label on top */
.lc-stage-group {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

.lc-stage-label {
    font-size: 10px;
    color: var(--lc-text-secondary);
    margin-bottom: 6px;
    white-space: nowrap;
}

.lc-stage-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

/* Keep old class for compatibility */
.lc-pipeline-card {
    min-width: 180px;
    max-width: 220px;
    padding: 12px 16px;
    background: var(--lc-pipeline-card-bg);
    border: 1px solid var(--lc-pipeline-card-border);
    border-radius: 6px;
    flex-shrink: 0;
}

.lc-pipeline-date {
    font-size: 11px;
    color: var(--lc-text-secondary);
}

.lc-stage-circle {
    display: flex;
    /* align-items: center; */
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: transparent;
    border: 2px solid var(--lc-stage-pending-border);
    font-size: 14px;
    font-weight: bold;
    color: var(--lc-text-secondary);
    cursor: pointer;
    transition: all .2s;
}

.lc-stage-circle:hover {
    transform: scale(1.1);
}

.lc-stage-circle.is-passed {
    background: #238636;
    border-color: #238636;
    color: #fff;
}

.lc-stage-circle.is-running {
    background: transparent;
    border-color: #ff8c00;
    color: #ff8c00;
    animation: stageSpin 1.5s linear infinite;
}

.lc-stage-circle.is-failed {
    background: transparent;
    border-color: #da3633;
    color: #da3633;
}

.lc-stage-circle.is-pending {
    background: transparent;
    border-color: #ff8c00;
    color: #ff8c00;
}

.lc-stage-circle.is-skipped {
    background: transparent;
    border-color: #6c757d;
    color: #6c757d;
}

@keyframes stageSpin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Stage Tooltip (GitLab style popup) - appears below */
.lc-stage-tooltip {
    display: none;
    position: absolute;
    top: calc(100% + 8px);
    left: 50%;
    transform: translateX(-50%);
    background: var(--lc-tooltip-bg);
    border: 1px solid var(--lc-tooltip-border);
    border-radius: 6px;
    padding: 0;
    min-width: 180px;
    z-index: 9999;
    box-shadow: 0 4px 12px rgba(0,0,0,.2);
}

/* Responsive - pipeline row */
@media (max-width: 900px) {
    .lc-pipeline-row {
        gap: 10px;
    }
    .lc-pipeline-bottom {
        flex-direction: column;
    }
    .lc-pipeline-table-header {
        font-size: 15px;
    }
    .lc-datatable {
        font-size: 12px;
    }
}

.lc-pipeline-row:hover {
    z-index: 9000;
}

.lc-stage-item:hover {
    z-index: 9999;
}

/* Tooltip shown via JS - fixed position to escape stacking context */
#lcFloatingTooltip {
    display: none;
    position: fixed;
    background: var(--lc-tooltip-bg);
    border: 1px solid var(--lc-tooltip-border);
    border-radius: 6px;
    min-width: 160px;
    z-index: 99999;
    box-shadow: 0 4px 12px rgba(0,0,0,.3);
}

#lcFloatingTooltip.is-visible {
    display: block;
}

/* Arrow points up (tooltip appears below circle) */
#lcFloatingTooltip::after {
    content: '';
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    border: 6px solid transparent;
    border-bottom-color: var(--lc-tooltip-bg);
}

.lc-stage-tooltip-header {
    padding: 8px 12px;
    background: var(--lc-tooltip-header-bg);
    border-bottom: 1px solid var(--lc-tooltip-border);
    font-size: 11px;
    color: var(--lc-text-secondary);
    border-radius: 6px 6px 0 0;
}

.lc-stage-tooltip-body {
    padding: 8px 12px;
}

.lc-stage-tooltip-job {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: var(--lc-text-primary);
    padding: 4px 0;
    cursor: pointer;
}

.lc-stage-tooltip-job:hover {
    color: #58a6ff;
}

.lc-stage-tooltip-icon {
    width: 16px;
    height: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
}

.lc-stage-tooltip-icon.is-passed { color: #238636; }
.lc-stage-tooltip-icon.is-failed { color: #da3633; }
.lc-stage-tooltip-icon.is-running { color: #1f6feb; }

/* Tooltip arrow - points up (tooltip appears below) */
.lc-stage-tooltip::after {
    content: '';
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    border: 6px solid transparent;
    border-bottom-color: var(--lc-tooltip-bg);
}

@keyframes stagePulse {
    0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(31, 111, 235, 0.4); }
    50% { opacity: 0.8; box-shadow: 0 0 0 6px rgba(31, 111, 235, 0); }
}

.lc-stage-arrow {
    width: 2px;
    height: 20px;
    background: #6c757d;
    margin: 0 auto;
    position: relative;
}

/* Actions column */
.lc-pipeline-actions {
    position: absolute;
    top: 12px;
    right: 0;
    z-index: 2;
}

.lc-pipeline-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: transparent;
    border: 1px solid var(--lc-pipeline-card-border);
    border-radius: 4px;
    color: var(--lc-text-secondary);
    cursor: pointer;
    font-size: 16px;
    transition: all .15s;
}

.lc-pipeline-btn:hover {
    background: var(--lc-hover-bg);
    border-color: var(--lc-text-secondary);
    color: var(--lc-text-primary);
}

/* Cancel button - red style */
.lc-pipeline-btn-cancel {
    color: #f85149;
    border-color: rgba(248, 81, 73, .4);
}

.lc-pipeline-btn-cancel:hover {
    background: rgba(248, 81, 73, .2);
    border-color: #f85149;
    color: #ff6b6b;
}

/* Day Separator (Default box for each day) */
.lc-show-day-separator {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    background: var(--lc-bg-tertiary);
    position: relative;
    z-index: 1;
    border-bottom: 1px solid var(--lc-border-light);
    flex-shrink: 0;
}

.lc-show-day-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 14px;
    background: var(--lc-bg-secondary);
    border: 1px solid var(--lc-border-color);
    border-radius: 4px;
    font-size: 12px;
    color: var(--lc-text-secondary);
}

.lc-show-day-badge svg {
    width: 16px;
    height: 16px;
    fill: #ff8c00;
}

.lc-show-day-badge-text {
    font-weight: 600;
    color: var(--lc-text-primary);
}

.lc-show-day-info {
    font-size: 11px;
    color: var(--lc-text-secondary);
    margin-left: auto;
}

/* Filter buttons group */
.lc-filter-group {
    display: flex;
    gap: 4px;
    margin-left: 12px;
}

.lc-filter-btn {
    padding: 4px 12px;
    font-size: 11px;
    font-weight: 500;
    color: var(--lc-text-secondary);
    background: transparent;
    border: 1px solid var(--lc-pipeline-card-border);
    border-radius: 4px;
    cursor: pointer;
    transition: all .15s;
}

.lc-filter-btn:hover {
    background: var(--lc-hover-bg);
    border-color: var(--lc-text-secondary);
    color: var(--lc-text-primary);
}

.lc-filter-btn.is-active {
    background: #0078d4;
    border-color: #0078d4;
    color: #fff;
}

/* ===== 3-Level Hierarchy Stepper (Year > Month > Day) ===== */
.lc-hierarchy {
    padding: 8px 0 8px 14px;
}

/* Level shared styles */
.lc-level {
    border-left: 2px solid #444;
    margin-left: 12px;
    position: relative;
}

/* Only hide last YEAR level's extending line (to prevent extending past footer) */
.lc-hierarchy > .lc-level.lc-year:last-child {
    border-left-color: transparent;
}

/* Short line to node for last year only */
.lc-hierarchy > .lc-level.lc-year:last-child::before {
    content: '';
    position: absolute;
    left: -2px;
    top: 0;
    height: 25px;
    border-left: 2px solid #0078d4;
}

.lc-level-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0px 5px;
    cursor: pointer;
    transition: background .15s;
    position: relative;
}

.lc-level-header:hover {
    background: var(--lc-hover-bg);
}

/* Circle node on the line */
.lc-level-node {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: #3c3c3c;
    border: 2px solid #666;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 600;
    color: #fff;
    position: absolute;
    left: -14px;
    flex-shrink: 0;
}

.lc-level-content {
    flex: 1;
    margin-left: 20px;
}

.lc-level-title {
    font-size: 13px;
    font-weight: 600;
    color: var(--lc-text-primary);
    display: flex;
    align-items: center;
    gap: 8px;
}

.lc-level-subtitle {
    font-size: 11px;
    color: var(--lc-text-secondary);
    margin-top: 2px;
}

.lc-level-toggle {
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--lc-text-secondary);
    transition: transform .2s;
}

.lc-level-toggle svg {
    width: 14px;
    height: 14px;
    fill: currentColor;
}

.lc-level.is-collapsed .lc-level-toggle {
    transform: rotate(-90deg);
}

.lc-level-body {
    padding-left: 5px;
    overflow: hidden;
    transition: max-height .3s ease, opacity .3s ease;
}

.lc-level.is-collapsed .lc-level-body {
    max-height: 0 !important;
    opacity: 0;
    overflow: hidden;
}

/* Count badge */
.lc-level-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 20px;
    height: 18px;
    padding: 0 6px;
    background: var(--lc-hover-bg);
    border-radius: 9px;
    font-size: 10px;
    color: var(--lc-text-secondary);
    font-weight: normal;
}

/* Year Level (Blue) - Darkest header */
.lc-year {
    border-color: #0078d4;
    margin-left: 0;
}

.lc-year > .lc-level-header {
    background: rgba(0, 120, 212, 0.25);
    border-radius: 6px;
    margin-right: 8px;
}

.lc-year > .lc-level-header:hover {
    background: rgba(0, 120, 212, 0.35);
}

.lc-year > .lc-level-header .lc-level-node {
    background: #0078d4;
    border-color: #0078d4;
    width: 30px;
    height: 30px;
    font-size: 12px;
    left: -16px;
}

.lc-year > .lc-level-header .lc-level-title {
    font-size: 15px;
    font-weight: 600;
    color: #1565c0;
}

.lc-year > .lc-level-header .lc-level-subtitle {
    color: #1565c0;
}

/* Month Level (Green) - Medium header */
.lc-month {
    border-color: #00cc6a;
}

.lc-month > .lc-level-header {
    background: rgba(0, 204, 106, 0.2);
    border-radius: 6px;
    margin-right: 8px;
}

.lc-month > .lc-level-header:hover {
    background: rgba(0, 204, 106, 0.3);
}

.lc-month > .lc-level-header .lc-level-node {
    background: #00cc6a;
    border-color: #00cc6a;
}

.lc-month > .lc-level-header .lc-level-title {
    font-weight: 500;
    color: #2e7d32;
}

.lc-month > .lc-level-header .lc-level-subtitle {
    color: #2e7d32;
}

/* Day Level (Orange) - Lightest header */
.lc-day {
    border-color: #ff8c00;
}

.lc-day > .lc-level-header {
    background: rgba(255, 140, 0, 0.15);
    border-radius: 6px;
    margin-right: 8px;
}

.lc-day > .lc-level-header:hover {
    background: rgba(255, 140, 0, 0.25);
}

.lc-day > .lc-level-header .lc-level-node {
    background: #ff8c00;
    border-color: #ff8c00;
}

.lc-day > .lc-level-header .lc-level-title {
    color: #e65100;
}

.lc-day > .lc-level-header .lc-level-subtitle {
    color: #f57c00;
}

/* Day content - contains pipeline items */
.lc-day-content {
    padding: 8px 0 16px 0;
    position: relative;
}

/* Fix tooltip z-index - bring entire hierarchy above when hovering */
.lc-day-content:has(.lc-stage-item:hover) {
    z-index: 9999;
}

.lc-level:has(.lc-stage-item:hover) {
    z-index: 9999 !important;
}

/* Pipeline Item */
.lc-pl-item {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 12px 0;
    position: relative;
    margin-left: 8px;
}

/* Node circle on main line */
.lc-pl-item::before {
    content: '';
    position: absolute;
    left: -24px;
    top: 20px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #555;
    border: 2px solid var(--lc-bg-primary);
    z-index: 1;
}

.lc-pl-item.is-passed::before { background: #00cc6a; }
.lc-pl-item.is-failed::before { background: #e51400; }
.lc-pl-item.is-running::before { background: #0078d4; }
.lc-pl-item.is-pending::before { background: #ff8c00; }

/* Pipeline Info Box */
.lc-pl-info {
    min-width: 200px;
    max-width: 240px;
    background: var(--lc-pipeline-card-bg);
    border: 1px solid var(--lc-pipeline-card-border);
    border-radius: 6px;
    padding: 10px 14px;
    flex-shrink: 0;
}

.lc-pl-info-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 6px;
}

.lc-pl-info-status {
    font-size: 9px;
    padding: 2px 8px;
    border-radius: 10px;
    font-weight: 600;
    text-transform: uppercase;
}

.lc-pl-info-status.passed { background: rgba(0, 204, 106, .2); color: #00cc6a; }
.lc-pl-info-status.failed { background: rgba(229, 20, 0, .2); color: #e51400; }
.lc-pl-info-status.running { background: rgba(0, 120, 212, .2); color: #0078d4; }
.lc-pl-info-status.pending { background: rgba(255, 140, 0, .2); color: #ff8c00; }

.lc-pl-info-time {
    font-size: 10px;
    color: var(--lc-text-secondary);
    display: flex;
    align-items: center;
    gap: 4px;
}

.lc-pl-info-title {
    font-size: 12px;
    font-weight: 600;
    color: var(--lc-text-primary);
    margin-bottom: 4px;
}

.lc-pl-info-meta {
    font-size: 10px;
    color: var(--lc-text-secondary);
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}

.lc-pl-info-tag {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 2px 6px;
    background: var(--lc-hover-bg);
    border-radius: 3px;
}

.lc-pl-info-tag.branch {
    background: rgba(0, 120, 212, .2);
    color: #4fc3f7;
}

/* Stages */
.lc-pl-stages {
    display: flex;
    align-items: center;
    gap: 4px;
    flex: 1;
    padding-top: 6px;
}

.lc-pl-stage-group {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

.lc-pl-stage-name {
    font-size: 9px;
    color: var(--lc-text-secondary);
    margin-bottom: 4px;
    text-transform: capitalize;
}

.lc-pl-stage-connector {
    width: 2px;
    height: 20px;
    background: #555;
    margin: 0 auto;
}

.lc-pl-stage {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: var(--lc-stage-pending-bg);
    border: 2px solid var(--lc-stage-pending-border);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all .15s;
    position: relative;
}

.lc-pl-stage:hover { transform: scale(1.1); }
.lc-pl-stage svg { width: 12px; height: 12px; fill: currentColor; }

.lc-pl-stage.passed { background: rgba(0, 204, 106, .2); border-color: #00cc6a; color: #00cc6a; }
.lc-pl-stage.failed { background: rgba(229, 20, 0, .2); border-color: #e51400; color: #e51400; }
.lc-pl-stage.running { background: rgba(0, 120, 212, .2); border-color: #0078d4; color: #0078d4; }
.lc-pl-stage.pending { background: var(--lc-stage-pending-bg); border-color: var(--lc-stage-pending-border); color: var(--lc-text-secondary); }
.lc-pl-stage.skipped { background: rgba(128, 128, 128, .2); border-color: #888; color: #888; }

/* Stage Tooltip (GitLab style) */
.lc-pl-stage-tooltip {
    display: none;
    position: absolute;
    top: calc(100% + 8px);
    left: 50%;
    transform: translateX(-50%);
    background: var(--lc-tooltip-bg);
    border: 1px solid var(--lc-tooltip-border);
    border-radius: 6px;
    min-width: 140px;
    z-index: 1000;
    box-shadow: 0 4px 12px rgba(0,0,0,.3);
}

.lc-pl-stage-tooltip-header {
    padding: 6px 10px;
    background: var(--lc-tooltip-header-bg);
    border-bottom: 1px solid var(--lc-tooltip-border);
    font-size: 10px;
    color: var(--lc-text-secondary);
    border-radius: 6px 6px 0 0;
}

.lc-pl-stage-tooltip-body { padding: 6px 10px; }

.lc-pl-stage-tooltip-job {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    color: var(--lc-text-primary);
}

.lc-pl-stage-tooltip-icon { font-size: 11px; }
.lc-pl-stage-tooltip-icon.is-passed { color: #00cc6a; }
.lc-pl-stage-tooltip-icon.is-failed { color: #e51400; }
.lc-pl-stage-tooltip-icon.is-running { color: #0078d4; }
.lc-pl-stage-tooltip-icon.is-pending { color: #ff8c00; }
.lc-pl-stage-tooltip-icon.is-skipped { color: #888; }

.lc-pl-stage-tooltip::before {
    content: '';
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    border: 5px solid transparent;
    border-bottom-color: var(--lc-tooltip-header-bg);
}

.lc-pl-stage-group:hover .lc-pl-stage-tooltip { display: block; }
.lc-pl-stage-group:hover { z-index: 1001; }

/* Footer */
.lc-graph-footer {
    padding: 8px 10px;
    border-top: 1px solid var(--lc-border-light);
    background: var(--lc-bg-tertiary);
    font-size: 11px;
    color: var(--lc-text-secondary);
    display: flex;
    justify-content: space-between;
}

/* .gitlab-pie-loader {
  width: 22px;
  height: 22px;
  display: inline-block;
  position: relative;
  border-radius: 50%;
  border: 2px solid #3f8fc9;
  background: #d9edf9;
}

.gitlab-pie-loader::before {
  content: "";
  position: absolute;
  inset: 3px; 
  border-radius: 50%;
  background:
    conic-gradient(
      from -90deg,
      #d9edf9 0deg 85deg,
      #2f80bf 85deg 360deg
    );
} */

</style>

{{-- Combined Panel (Left Sidebar) --}}
<div class="lc-panel" id="lcPanel">
    <div class="lc-panel-resizer" id="lcPanelResizer"></div>
    {{-- Edge resize handles for float mode (on panel level) --}}
    <div class="lc-float-edge top"></div>
    <div class="lc-float-edge bottom"></div>
    <div class="lc-float-edge left"></div>
    <div class="lc-float-edge right"></div>
    <div class="lc-float-edge top-left"></div>
    <div class="lc-float-edge top-right"></div>
    <div class="lc-float-edge bottom-left"></div>
    <div class="lc-float-edge bottom-right"></div>

{{-- ===== Graph Section (top) ===== --}}
<aside class="lc-graph" id="lcGraph">
    <div class="lc-graph-resizer" id="lcGraphResizer"></div>

    <div class="lc-graph-header">
        <div class="lc-graph-header-top">
            <span class="lc-graph-title">
                <svg class="lc-graph-title-icon" viewBox="0 0 16 16" width="16" height="16" aria-hidden="true">
                    <path d="M4 2v12" stroke="#e51400" stroke-width="1.6" stroke-linecap="round"/>
                    <path d="M8 2v12" stroke="#00cc6a" stroke-width="1.6" stroke-linecap="round"/>
                    <path d="M12 2v12" stroke="#cc00cc" stroke-width="1.6" stroke-linecap="round"/>
                    <path d="M4 5 C6 5, 6 7, 8 7" fill="none" stroke="#0078d4" stroke-width="1.6" stroke-linecap="round"/>
                    <path d="M8 9 C10 9, 10 11, 12 11" fill="none" stroke="#0078d4" stroke-width="1.6" stroke-linecap="round"/>
                    <circle cx="4" cy="5" r="1.6" fill="#e51400"/>
                    <circle cx="8" cy="7" r="1.6" fill="#0078d4"/>
                    <circle cx="8" cy="9" r="1.6" fill="#00cc6a"/>
                    <circle cx="12" cy="11" r="1.6" fill="#cc00cc"/>
                </svg>

                <span class="gitlab-pie-loader"></span>

                <span id="lcGraphTitleText">Laravel Control</span>
                <span class="lc-graph-fullscreen-badge" id="lcGraphFullscreenBadge">
                    <span class="lc-graph-branch-icon" id="lcGraphBranchIcon">
                        <svg viewBox="0 0 16 16">
                            <path d="M9.5 3.25a2.25 2.25 0 1 1 3 2.122V6A2.5 2.5 0 0 1 10 8.5H6a1 1 0 0 0-1 1v1.128a2.251 2.251 0 1 1-1.5 0V5.372a2.25 2.25 0 1 1 1.5 0v1.836A2.493 2.493 0 0 1 6 7h4a1 1 0 0 0 1-1v-.628A2.25 2.25 0 0 1 9.5 3.25Zm-6 0a.75.75 0 1 0 1.5 0 .75.75 0 0 0-1.5 0Zm8.25-.75a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5ZM4.25 12a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5Z"/>
                        </svg>
                    </span>
                    <span class="lc-graph-title-badge" id="lcGraphBadge">All Branches</span>
                    <span class="lc-graph-head-tag" id="lcGraphHeadTag">HEAD</span>
                </span>
            </span>
            <div class="lc-graph-controls">
                <button class="lc-graph-btn lc-graph-btn-expand" id="lcGraphExpand" title="ขยาย/ย่อเต็มจอ">&#x21c6; Expand</button>
                <button class="lc-graph-btn lc-graph-btn-back" id="lcGraphBack" title="Back to branches">&#8592; Back</button>
                <button class="lc-graph-btn" id="lcGraphRefresh" title="Refresh">&#x21bb;</button>
                <button class="lc-graph-btn" id="lcGraphCollapseAll" title="Collapse All">&#x2212;</button>
                <button class="lc-graph-btn" id="lcGraphExpandAll" title="Expand All">&#x2b;</button>
                <button class="lc-graph-btn" id="lcGraphFloat" title="Float window">&#x2750;</button>
                <button class="lc-graph-btn" id="lcGraphClose" title="Close">&times;</button>
            </div>
        </div>
        <div class="lc-graph-search">
            <input type="text" id="lcGraphSearch" placeholder="Search routes..." />
        </div>
    </div>

    <div class="lc-graph-body" id="lcGraphBody">
        <div class="lc-graph-loading">Loading branches...</div>
    </div>

    {{-- Commits View (shown in fullscreen mode) --}}
    <div class="lc-graph-commits" id="lcGraphCommits">
        <div class="lc-show-day-separator" id="lcShowDaySeparator">
            <div class="lc-show-day-badge">
                <svg viewBox="0 0 24 24">
                    <path d="M6 2v6l4 4-4 4v6h12v-6l-4-4 4-4V2H6zm10 14.5V20H8v-3.5l4-4 4 4zm-4-5l-4-4V4h8v3.5l-4 4z"/>
                </svg>
                <span class="lc-show-day-badge-text" id="lcShowDayText">27 Jan 2026</span>
            </div>
            <div class="lc-filter-group">
                <button class="lc-filter-btn is-active" data-filter="day" title="Filter by Day">Day</button>
                <button class="lc-filter-btn" data-filter="month" title="Filter by Month">Month</button>
                <button class="lc-filter-btn" data-filter="year" title="Filter by Year">Year</button>
            </div>
            <span class="lc-show-day-info" id="lcShowDayInfo">Today</span>
        </div>
        <div class="lc-show-body" id="lcShowBody">
            <div class="lc-show-empty">
                <span style="color: #888;">No data</span>
            </div>
        </div>
    </div>

    <div class="lc-graph-footer">
        <span id="lcGraphTotal">0 branches</span>
        <span id="lcGraphCurrent">No role selected</span>
    </div>
</aside>

{{-- ===== Terminal Section (bottom) ===== --}}
<div class="lc-terminal" id="lcTerminal">
    <div class="lc-terminal-resizer" id="lcTerminalResizer"></div>

    <div class="lc-terminal-header">
        <div class="lc-terminal-header-left">
            <span class="lc-terminal-title">
                <svg class="w-5 h-10" viewBox="0 0 28 28" aria-hidden="true">
                    <!-- rounded square background -->
                    <rect x="2" y="2" width="24" height="24" rx="5" fill="currentColor" fill-opacity="0.18" stroke="currentColor" stroke-opacity="0.45" stroke-width="1.5"/>
                    <!-- terminal symbol >_ -->
                    <path d="M8.2 10.2l5 3.8-5 3.8"
                            fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M14.5 18.2h5.3" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                Laravel Control Terminal
            </span>
            <!-- <span class="lc-terminal-shortcut">Ctrl + `</span> -->
        </div>
        <div class="lc-terminal-header-right">
            <button class="lc-btn" id="lcTerminalClear">Clear</button>
            <button class="lc-btn" id="lcTerminalClose">&times;</button>
        </div>
    </div>

    <div class="lc-terminal-body" id="lcTerminalOutput"></div>

    <div class="lc-terminal-input-wrap">
        <input type="text" class="lc-terminal-input" id="lcTerminalInput"
            placeholder="laravel status / laravel branch / laravel checkout <role>"
            autocomplete="off" spellcheck="false" />
        <button class="lc-btn" id="lcTerminalRun">Run</button>
    </div>
</div>

</div> {{-- End .lc-panel --}}

{{-- Floating Tooltip (outside stacking context) --}}
<div id="lcFloatingTooltip">
    <div class="lc-stage-tooltip-header" id="lcTooltipHeader">Stage: payment</div>
    <div class="lc-stage-tooltip-body" id="lcTooltipBody">
        <div class="lc-stage-tooltip-job">
            <span class="lc-stage-tooltip-icon">○</span>
            <span id="lcTooltipJobName">payment</span>
        </div>
    </div>
</div>

<script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
<script src="{{ asset('js/flowbite-2.3.0.min.js') }}"></script>
<script src="{{ asset('js/3.10.1-jszip.min.js') }}"></script>
<script src="{{ asset('js/2.0.5-dataTables.js') }}"></script>
<script src="{{ asset('js/3.0.2-dataTables.buttons.js') }}"></script>
<script src="{{ asset('js/3.0.2-buttons.bootstrap5.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('js/buttons-html5.min.js') }}"></script>
<script src="{{ asset('js/buttons-print.min.js') }}"></script>
<script src="{{ asset('js/buttons-colVis.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('js/select2@4.1.0.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2@11.min.js') }}"></script>

<script>
(function() {
    'use strict';

    // Elements
    const panel = document.getElementById('lcPanel');
    const panelResizer = document.getElementById('lcPanelResizer');
    const terminal = document.getElementById('lcTerminal');
    const terminalOutput = document.getElementById('lcTerminalOutput');
    const terminalInput = document.getElementById('lcTerminalInput');
    const terminalResizer = document.getElementById('lcTerminalResizer');
    const btnRun = document.getElementById('lcTerminalRun');
    const btnClear = document.getElementById('lcTerminalClear');
    const btnClose = document.getElementById('lcTerminalClose');

    const graph = document.getElementById('lcGraph');
    const graphBody = document.getElementById('lcGraphBody');
    const graphSearch = document.getElementById('lcGraphSearch');
    const graphTotal = document.getElementById('lcGraphTotal');
    const graphCurrent = document.getElementById('lcGraphCurrent');
    const btnGraphClose = document.getElementById('lcGraphClose');
    const btnGraphRefresh = document.getElementById('lcGraphRefresh');

    // Current user ID (passed from Blade)
    const currentUserId = {{ auth()->id() ?? 'null' }};
    const btnGraphCollapseAll = document.getElementById('lcGraphCollapseAll');
    const btnGraphExpandAll = document.getElementById('lcGraphExpandAll');

    // Fullscreen commits elements (inside graph panel)
    const graphCommits = document.getElementById('lcGraphCommits');
    const showBody = document.getElementById('lcShowBody');
    const graphTitleText = document.getElementById('lcGraphTitleText');
    const graphBadge = document.getElementById('lcGraphBadge');
    const graphHeadTag = document.getElementById('lcGraphHeadTag');
    const btnGraphBack = document.getElementById('lcGraphBack');

    // Day separator elements
    const showDayText = document.getElementById('lcShowDayText');
    const showDayInfo = document.getElementById('lcShowDayInfo');

    // Set current date on load
    function updateDaySeparator(date = new Date()) {
        const options = { day: '2-digit', month: 'short', year: 'numeric' };
        showDayText.textContent = date.toLocaleDateString('en-GB', options);

        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const compareDate = new Date(date);
        compareDate.setHours(0, 0, 0, 0);

        const diffDays = Math.floor((today - compareDate) / (1000 * 60 * 60 * 24));

        if (diffDays === 0) {
            showDayInfo.textContent = 'Today';
        } else if (diffDays === 1) {
            showDayInfo.textContent = 'Yesterday';
        } else if (diffDays > 1 && diffDays < 7) {
            showDayInfo.textContent = `${diffDays} days ago`;
        } else {
            showDayInfo.textContent = '';
        }
    }

    // Initialize day separator
    updateDaySeparator();

    // State
    const LC_HISTORY_KEY = 'lc_command_history';
    let commandHistory = (function() {
        try { return JSON.parse(localStorage.getItem(LC_HISTORY_KEY) || '[]'); } catch(e) { return []; }
    })();
    let historyIndex = commandHistory.length;
    let branchesData = null;

    // Brand colors mapping
    const brandColors = ['green', 'cyan', 'magenta', 'yellow', 'red', 'orange', 'blue', 'pink'];
    let colorIndex = 0;

    const API_BASE = '/api/laravel-control';

    // ===== Panel State Persistence =====
    const LC_STATE_KEY = 'lc_panel_state';

    function savePanelState() {
        const state = {
            open: panel.classList.contains('is-open'),
            floating: panel.classList.contains('is-floating'),
            fullscreen: panel.classList.contains('is-fullscreen'),
            expanded: panel.classList.contains('is-expanded'),
            top: panel.style.top || '',
            left: panel.style.left || '',
            width: panel.style.width || '',
            height: panel.style.height || '',
        };
        localStorage.setItem(LC_STATE_KEY, JSON.stringify(state));
    }

    function restorePanelState() {
        try {
            const raw = localStorage.getItem(LC_STATE_KEY);
            if (!raw) return;
            const s = JSON.parse(raw);
            if (!s.open) return;

            panel.classList.add('is-open');
            loadBranches();
            if (terminalOutput.children.length === 0) printWelcome();

            if (s.floating) {
                panel.classList.add('is-floating');
                if (s.top) panel.style.top = s.top;
                if (s.left) panel.style.left = s.left;
                if (s.width) panel.style.width = s.width;
                if (s.height) panel.style.height = s.height;
                const floatBtn = document.getElementById('lcGraphFloat');
                if (floatBtn) { floatBtn.innerHTML = '&#x25A3;'; floatBtn.title = 'Restore default'; }
            }

            if (s.fullscreen) panel.classList.add('is-fullscreen');
            if (s.expanded) panel.classList.add('is-expanded');
        } catch (e) { /* ignore corrupt state */ }
    }

    // ===== Panel Functions =====
    function openPanel() {
        panel.classList.add('is-open');
        loadBranches();
        setTimeout(() => terminalInput.focus(), 50);
        if (terminalOutput.children.length === 0) {
            printWelcome();
        }
        savePanelState();
    }

    function closePanel() {
        panel.classList.remove('is-open', 'is-floating', 'is-fullscreen', 'is-expanded');
        panel.style.top = '';
        panel.style.left = '';
        panel.style.width = '';
        panel.style.height = '';
        const floatBtn = document.getElementById('lcGraphFloat');
        if (floatBtn) { floatBtn.innerHTML = '&#x2750;'; floatBtn.title = 'Float window'; }
        const expandBtn = document.getElementById('lcGraphExpand');
        if (expandBtn) expandBtn.innerHTML = '&#x21c6; Expand';
        graphHeadTag.style.display = '';
        savePanelState();
    }

    function togglePanel() {
        panel.classList.contains('is-open') ? closePanel() : openPanel();
    }

    // ===== Terminal Functions =====
    function openTerminal() {
        openPanel();
    }

    function closeTerminal() {
        closePanel();
    }

    function toggleTerminal() {
        togglePanel();
    }

    function printLine(text, className = '') {
        const line = document.createElement('div');
        line.className = 'lc-terminal-line ' + className;
        line.textContent = text;
        terminalOutput.appendChild(line);
        terminalOutput.scrollTop = terminalOutput.scrollHeight;
    }

    function printBranches(branches, current) {
        if (!branches || branches.length === 0) {
            printLine('No roles available for current user', 'muted');
            return;
        }
        branches.forEach(branch => {
            const isCurrent = branch.current === true;
            const line = document.createElement('div');
            line.className = 'lc-branch-line';
            line.innerHTML = isCurrent
                ? `<span class="lc-branch-marker">*</span> <span class="lc-branch-current">${branch.name}</span>`
                : `<span style="margin-left:18px;">${branch.name}</span>`;
            terminalOutput.appendChild(line);
        });
        terminalOutput.scrollTop = terminalOutput.scrollHeight;
    }

    function printWelcome() {
        printLine('Laravel Control v1.0', 'muted');
        printLine("Type 'laravel help' for available commands", 'muted');
        printLine('');
    }

    function clearTerminal() {
        terminalOutput.innerHTML = '';
        printWelcome();
    }

    // ===== Graph Functions =====
    function openGraph() {
        openPanel();
    }

    function closeGraph() {
        closePanel();
    }

    function toggleGraph() {
        panel.classList.contains('is-open') ? closeGraph() : openGraph();
    }

    function getBrandColor(index) {
        return brandColors[index % brandColors.length];
    }

    /**
     * Run automated test on a route URL.
     * Sets blinking state, fetches the URL, then shows pass/fail.
     */
    async function runTest(path, childEl) {
        // Reset previous state
        childEl.classList.remove('is-passed', 'is-failed');
        childEl.classList.add('is-testing');

        // Remove old result icon if any
        const oldIcon = childEl.querySelector('.lc-test-result');
        if (oldIcon) oldIcon.remove();

        const childName = childEl.querySelector('.lc-tree-child-name')?.textContent || path;
        printLine(`> testing ${childName} (${path})...`, 'cmd');

        try {
            const res = await fetch(path, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                credentials: 'same-origin',
            });

            childEl.classList.remove('is-testing');

            if (res.ok) {
                childEl.classList.add('is-passed');
                childEl.insertAdjacentHTML('beforeend', '<span class="lc-test-result lc-test-pass">✓</span>');
                printLine(`  ✓ ${childName} — PASSED (${res.status})`, 'success');
            } else {
                childEl.classList.add('is-failed');
                childEl.insertAdjacentHTML('beforeend', '<span class="lc-test-result lc-test-fail">✕</span>');
                printLine(`  ✕ ${childName} — FAILED (${res.status})`, 'error');
            }
        } catch (err) {
            childEl.classList.remove('is-testing');
            childEl.classList.add('is-failed');
            childEl.insertAdjacentHTML('beforeend', '<span class="lc-test-result lc-test-fail">✕</span>');
            printLine(`  ✕ ${childName} — ERROR: ${err.message}`, 'error');
        }

        printLine('');
    }

    /**
     * Run all children tests for a branch sequentially.
     */
    async function runAllTests(branchEl) {
        const children = branchEl.querySelectorAll('.lc-tree-child');
        for (const child of children) {
            const path = child.dataset.path;
            if (path) await runTest(path, child);
        }
    }

    // ===== Test Results Persistence =====
    const LC_RESULTS_KEY = 'lc_test_results';

    function saveTestResult(childKey, status) {
        // status: 'passed' or 'failed'
        let results = {};
        try { results = JSON.parse(localStorage.getItem(LC_RESULTS_KEY) || '{}'); } catch(e) {}
        results[childKey] = status;
        localStorage.setItem(LC_RESULTS_KEY, JSON.stringify(results));
    }

    function restoreTestResults() {
        let results = {};
        try { results = JSON.parse(localStorage.getItem(LC_RESULTS_KEY) || '{}'); } catch(e) {}
        Object.keys(results).forEach(key => {
            const childEl = document.querySelector(`.lc-tree-child[data-key="${key}"]`);
            if (!childEl) return;
            const status = results[key];
            childEl.classList.remove('is-testing', 'is-passed', 'is-failed');
            const oldIcon = childEl.querySelector('.lc-test-result');
            if (oldIcon) oldIcon.remove();
            // Show stages wrap
            const stagesWrap = document.querySelector(`.lc-stages-wrap[data-child-key="${key}"]`);
            if (stagesWrap) stagesWrap.classList.add('has-results');

            if (status === 'passed') {
                childEl.classList.add('is-passed');
                childEl.insertAdjacentHTML('beforeend', '<span class="lc-test-result lc-test-pass">✓</span>');
                // Restore all stage circles as passed
                const stagesContainer = document.querySelector(`.lc-stages[data-child-key="${key}"]`);
                if (stagesContainer) {
                    const stages = stagesContainer.querySelectorAll('.lc-stage');
                    stages.forEach(sc => {
                        sc.classList.add('is-passed');
                        const label = sc.dataset.label || '';
                        sc.innerHTML = `<span class="lc-stage-tooltip">${label}: passed</span>✓`;
                    });
                    updateStagesPercent(key, stages.length, stages.length);
                }
            } else if (status === 'failed') {
                childEl.classList.add('is-failed');
                childEl.insertAdjacentHTML('beforeend', '<span class="lc-test-result lc-test-fail">✕</span>');
                // Restore all stage circles as failed
                const stagesContainer = document.querySelector(`.lc-stages[data-child-key="${key}"]`);
                if (stagesContainer) {
                    const stages = stagesContainer.querySelectorAll('.lc-stage');
                    const passedCount = stagesContainer.querySelectorAll('.lc-stage.is-passed').length;
                    stages.forEach(sc => {
                        if (!sc.classList.contains('is-passed')) {
                            sc.classList.add('is-failed');
                            const label = sc.dataset.label || '';
                            sc.innerHTML = `<span class="lc-stage-tooltip">${label}: failed</span>✕`;
                        }
                    });
                    updateStagesPercent(key, passedCount, stages.length);
                    // Color the percent red for failed
                    const pct = stagesWrap.querySelector('.lc-stages-percent');
                    if (pct) pct.style.color = '#da3633';
                }
            }
        });
        requestAnimationFrame(() => fixTreeLines());
    }

    /**
     * Play trail animation: pulse from parent branch → down the line → to target child
     * CSS names: .lc-trail-source, .lc-trail-pulse, .lc-trail-target
     */
    /**
     * Play dot trail animation: dot travels along tree lines from parent → child
     * Uses .lc-tree-children as container (position: relative)
     * Vertical line: left 8px | Horizontal connector: left -13px, width 12px
     * CSS names: .lc-trail-source, .lc-trail-dot
     */
    function playTrailAnimation(childKey) {
        const childEl = document.querySelector(`.lc-tree-child[data-key="${childKey}"]`);
        if (!childEl) return;

        const childrenContainer = childEl.closest('.lc-tree-children');
        if (!childrenContainer) return;

        const parentBranch = childrenContainer.previousElementSibling;
        if (!parentBranch) return;

        // Glow parent
        parentBranch.classList.add('lc-trail-source');

        // childEl position relative to childrenContainer
        const containerRect = childrenContainer.getBoundingClientRect();
        const childRect = childEl.getBoundingClientRect();

        // Vertical line X = 8px (same as ::before left)
        const lineX = 8;
        // Child center Y relative to container
        const childY = childRect.top - containerRect.top + childRect.height / 2;

        // Create dot inside childrenContainer
        const dot = document.createElement('div');
        dot.className = 'lc-trail-dot';
        childrenContainer.appendChild(dot);

        // Start at top of vertical line
        dot.style.left = (lineX - 4) + 'px';
        dot.style.top = '-4px';
        dot.style.opacity = '1';

        // Phase 1: travel down vertical line to child's Y
        setTimeout(() => {
            dot.style.transition = 'top 0.5s ease-in-out';
            dot.style.top = (childY - 4) + 'px';
        }, 50);

        // Phase 2: travel right along horizontal connector (12px + gap to child)
        setTimeout(() => {
            // End X = childEl left relative to container
            const endX = childRect.left - containerRect.left;
            dot.style.transition = 'left 0.4s ease-in-out';
            dot.style.left = (endX - 4) + 'px';
        }, 600);

        // Phase 3: arrive → fade dot
        setTimeout(() => {
            dot.style.transition = 'opacity 0.3s';
            dot.style.opacity = '0';
        }, 1050);

        // Clean up
        setTimeout(() => {
            dot.remove();
            parentBranch.classList.remove('lc-trail-source');
        }, 1400);
    }

    // ===== Automated Test Runner (Form Interaction) =====
    const LC_TEST_KEY = 'lc_auto_test';

    function startAutoTest(child) {
        // child = { key, path, name, test_steps: [...] }
        const testState = {
            childKey: child.key,
            childName: child.name,
            path: child.path,
            steps: child.test_steps,
            currentStep: 0,
            status: 'navigating', // navigating → running → done
        };
        localStorage.setItem(LC_TEST_KEY, JSON.stringify(testState));
        // Navigate to the page
        window.location.href = child.path;
    }

    function getAutoTestState() {
        try {
            const raw = localStorage.getItem(LC_TEST_KEY);
            return raw ? JSON.parse(raw) : null;
        } catch (e) { return null; }
    }

    function clearAutoTest() {
        localStorage.removeItem(LC_TEST_KEY);
    }

    function updateStagesPercent(childKey, completed, total) {
        const wrap = document.querySelector(`.lc-stages-wrap[data-child-key="${childKey}"]`);
        if (!wrap) return;
        const pct = wrap.querySelector('.lc-stages-percent');
        if (!pct) return;
        const percent = Math.round((completed / total) * 100);
        if (percent >= 100) {
            pct.textContent = ' 100%';
            pct.style.color = '#3fb950';
        } else {
            pct.textContent = ` ${percent}%`;
            pct.style.color = '#3fb950';
        }

        // Update pie loader progress
        const childEl = document.querySelector(`.lc-tree-child[data-key="${childKey}"]`);
        if (childEl) {
            const pie = childEl.querySelector('.gitlab-pie-loader');
            if (pie) {
                const deg = Math.round((completed / total) * 360);
                pie.style.setProperty('--progress', deg + 'deg');
            }
        }
    }

    function addGlassOverlay(el, label) {
        // Ensure parent is positioned
        const parent = el.closest('.md\\:col-span-2') || el.parentElement;
        if (parent && getComputedStyle(parent).position === 'static') {
            parent.style.position = 'relative';
        }
        const overlay = document.createElement('div');
        overlay.className = 'lc-test-overlay';
        overlay.innerHTML = `<span class="lc-test-overlay-label">${label}</span>`;
        (parent || el.parentElement).appendChild(overlay);
        return overlay;
    }

    function markOverlayDone(overlay) {
        if (overlay) overlay.classList.add('is-done');
    }

    function markOverlayError(overlay, label) {
        if (!overlay) return;
        overlay.classList.remove('is-done');
        overlay.classList.add('is-error');
        const lbl = overlay.querySelector('.lc-test-overlay-label');
        if (lbl && label) lbl.textContent = label;
    }

    function failAutoTest(state, errorMsg) {
        // Stop blinking on tree child
        const childEl = document.querySelector(`.lc-tree-child[data-key="${state.childKey}"]`);
        if (childEl) {
            childEl.classList.remove('is-testing');
            childEl.classList.add('is-failed');
            const oldIcon = childEl.querySelector('.lc-test-result');
            if (oldIcon) oldIcon.remove();
            childEl.insertAdjacentHTML('beforeend', '<span class="lc-test-result lc-test-fail">✕</span>');
        }

        // Mark all existing overlays as error (red)
        document.querySelectorAll('.lc-test-overlay:not(.is-done):not(.is-error)').forEach(ov => {
            markOverlayError(ov, 'Error');
        });

        // Mark remaining stage circles as failed + update percent
        const stagesContainer = document.querySelector(`.lc-stages[data-child-key="${state.childKey}"]`);
        if (stagesContainer) {
            stagesContainer.querySelectorAll('.lc-stage:not(.is-passed)').forEach(sc => {
                sc.classList.add('is-failed');
                const label = sc.dataset.label || '';
                sc.innerHTML = `<span class="lc-stage-tooltip">${label}: failed</span>✕`;
            });
            const total = stagesContainer.querySelectorAll('.lc-stage').length;
            const passed = stagesContainer.querySelectorAll('.lc-stage.is-passed').length;
            updateStagesPercent(state.childKey, passed, total);
            const wrap = document.querySelector(`.lc-stages-wrap[data-child-key="${state.childKey}"]`);
            if (wrap) {
                const pct = wrap.querySelector('.lc-stages-percent');
                if (pct) pct.style.color = '#da3633';
            }
        }

        // Save failed result
        saveTestResult(state.childKey, 'failed');

        printLine(`  ✕ Auto test FAILED: ${state.childName}`, 'error');
        if (errorMsg) printLine(`    ${errorMsg}`, 'error');
        printLine('');

        state.status = 'done';
        clearAutoTest();
    }

    async function resumeAutoTest() {
        const state = getAutoTestState();
        if (!state || state.status === 'done') return;

        // Check if we're on the correct page
        if (!window.location.pathname.includes(state.path.replace(/^\//, ''))) return;

        state.status = 'running';
        localStorage.setItem(LC_TEST_KEY, JSON.stringify(state));

        // Play trail animation: Product Master → Create
        playTrailAnimation(state.childKey);

        // Mark child as testing (blinking) after trail arrives
        const testingChild = document.querySelector(`.lc-tree-child[data-key="${state.childKey}"]`);
        if (testingChild) {
            // Remove any old ✓/✕ icons
            const oldIcon = testingChild.querySelector('.lc-test-result');
            if (oldIcon) oldIcon.remove();
        }

        // Show stages wrap and expand it (only current step gets spinner)
        const stagesWrap = document.querySelector(`.lc-stages-wrap[data-child-key="${state.childKey}"]`);
        if (stagesWrap) {
            stagesWrap.classList.add('has-results', 'is-expanded');
            fixTreeLines();
        }

        // Wait for trail animation to finish (1.4s), then start blinking
        await new Promise(r => setTimeout(r, 1500));
        if (testingChild) testingChild.classList.add('is-testing');

        printLine(`> Auto test: ${state.childName}`, 'cmd');
        printLine(`  Steps: ${state.steps.length}`, 'muted');

        // Show initial percentage
        updateStagesPercent(state.childKey, state.currentStep, state.steps.length);

        for (let i = state.currentStep; i < state.steps.length; i++) {
            const step = state.steps[i];
            state.currentStep = i;
            localStorage.setItem(LC_TEST_KEY, JSON.stringify(state));

            printLine(`  [${i + 1}/${state.steps.length}] ${step.label}...`, 'cmd');

            // Reference stage circle for pass/fail update
            const stageCircle = document.querySelector(`.lc-stages[data-child-key="${state.childKey}"] .lc-stage[data-step-id="${step.id}"]`);

            const el = document.querySelector(step.selector);
            if (!el) {
                if (stageCircle) { stageCircle.classList.add('is-failed'); stageCircle.innerHTML = `<span class="lc-stage-tooltip">${step.label}: failed<br>Element not found</span>✕`; }
                failAutoTest(state, `Element not found: ${step.selector}`);
                return;
            }

            const overlay = addGlassOverlay(el, `Testing: ${step.label}`);
            let stepResultText = '';

            // Wait a moment for visual feedback
            await new Promise(r => setTimeout(r, 800));

            if (step.action === 'select') {
                // Select brand based on user's default
                let val = step.value;
                if (val === 'user_brand') {
                    const opts = el.querySelectorAll('option');
                    val = '';
                    for (const opt of opts) {
                        if (opt.value && opt.value !== '') {
                            val = opt.value;
                            break;
                        }
                    }
                }

                if (val) {
                    if (window.jQuery && jQuery(el).hasClass('js-example-basic-single')) {
                        jQuery(el).select2('open');
                        await new Promise(r => setTimeout(r, 800));
                        jQuery(el).val(val).trigger('change');
                        jQuery(el).select2('close');
                    } else {
                        el.value = val;
                        el.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                    stepResultText = `Selected: ${val}`;
                    printLine(`    ✓ ${stepResultText}`, 'success');
                }

                await new Promise(r => setTimeout(r, 1500));
            }

            if (step.action === 'select_first') {
                let attempts = 0;
                const maxAttempts = 20;

                while (attempts < maxAttempts) {
                    await new Promise(r => setTimeout(r, 500));
                    const opts = el.querySelectorAll('option');
                    const hasRealOption = Array.from(opts).some(o => o.value && o.value !== '' && !o.textContent.includes('LOADING') && !o.textContent.includes('กรุณาเลือก'));
                    if (hasRealOption) break;
                    attempts++;
                }

                const opts = el.querySelectorAll('option');
                let firstVal = '';
                for (const opt of opts) {
                    if (opt.value && opt.value !== '' && !opt.textContent.includes('LOADING') && !opt.textContent.includes('กรุณาเลือก')) {
                        firstVal = opt.value;
                        break;
                    }
                }

                if (firstVal) {
                    if (window.jQuery && jQuery(el).hasClass('js-example-basic-single')) {
                        jQuery(el).select2('open');
                        await new Promise(r => setTimeout(r, 800));
                        jQuery(el).val(firstVal).trigger('change');
                        jQuery(el).select2('close');
                    } else {
                        el.value = firstVal;
                        el.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                    stepResultText = `Selected first: ${el.options[el.selectedIndex]?.text || firstVal}`;
                    printLine(`    ✓ ${stepResultText}`, 'success');
                } else {
                    markOverlayError(overlay, `Error: ${step.label}`);
                    if (stageCircle) { stageCircle.classList.add('is-failed'); stageCircle.innerHTML = `<span class="lc-stage-tooltip">${step.label}: failed<br>No options available</span>✕`; }
                    failAutoTest(state, `No options available for ${step.label}`);
                    return;
                }

                await new Promise(r => setTimeout(r, 500));
            }

            if (step.action === 'highlight') {
                if (step.wait_for === 'value_filled') {
                    let attempts = 0;
                    const maxAttempts = 20;
                    while (attempts < maxAttempts) {
                        await new Promise(r => setTimeout(r, 500));
                        if (el.value && el.value.trim() !== '') break;
                        attempts++;
                    }
                }

                if (el.value && el.value.trim() !== '') {
                    stepResultText = `Auto-filled: ${el.value}`;
                    printLine(`    ✓ ${stepResultText}`, 'success');
                } else {
                    stepResultText = `Waiting for value (empty)`;
                    printLine(`    ● ${stepResultText}`, 'muted');
                }

                await new Promise(r => setTimeout(r, 800));
            }

            if (step.action === 'type') {
                const text = step.value || '';
                el.focus();
                el.value = '';
                for (let ci = 0; ci < text.length; ci++) {
                    el.value += text[ci];
                    el.dispatchEvent(new Event('input', { bubbles: true }));
                    await new Promise(r => setTimeout(r, 50));
                }
                el.dispatchEvent(new Event('change', { bubbles: true }));
                stepResultText = `Typed: ${text}`;
                printLine(`    ✓ ${stepResultText}`, 'success');

                await new Promise(r => setTimeout(r, 500));
            }

            markOverlayDone(overlay);

            // Mark stage circle as passed with result tooltip
            if (stageCircle) {
                stageCircle.classList.add('is-passed');
                stageCircle.innerHTML = `<span class="lc-stage-tooltip">${step.label}: passed<br>✓ ${stepResultText}</span>✓`;
            }

            // Update percentage
            updateStagesPercent(state.childKey, i + 1, state.steps.length);

            await new Promise(r => setTimeout(r, 600));
        }

        // All done
        state.status = 'done';
        state.currentStep = state.steps.length;
        localStorage.setItem(LC_TEST_KEY, JSON.stringify(state));
        printLine(`  ✓ Auto test PASSED: ${state.childName}`, 'success');
        printLine('');

        // Mark child in panel as passed
        const childEl = document.querySelector(`.lc-tree-child[data-key="${state.childKey}"]`);
        if (childEl) {
            childEl.classList.remove('is-testing');
            childEl.classList.add('is-passed');
            const oldIcon = childEl.querySelector('.lc-test-result');
            if (oldIcon) oldIcon.remove();
            childEl.insertAdjacentHTML('beforeend', '<span class="lc-test-result lc-test-pass">✓</span>');
        }

        // Save result persistently
        saveTestResult(state.childKey, 'passed');

        clearAutoTest();
    }

    function renderBranchTree(data) {
        if (!data || !data.groups || data.groups.length === 0) {
            graphBody.innerHTML = '<div class="lc-graph-empty">No branches found</div>';
            return;
        }

        const tree = document.createElement('div');
        tree.className = 'lc-tree';

        data.groups.forEach((group, groupIndex) => {
            const color = getBrandColor(groupIndex);
            const brandEl = document.createElement('div');
            brandEl.className = 'lc-tree-brand';
            brandEl.dataset.color = color;
            brandEl.dataset.brand = group.brand;

            // Git branch icon SVG
            const branchIcon = `<svg viewBox="0 0 16 16"><path d="M9.5 3.25a2.25 2.25 0 1 1 3 2.122V6A2.5 2.5 0 0 1 10 8.5H6a1 1 0 0 0-1 1v1.128a2.251 2.251 0 1 1-1.5 0V5.372a2.25 2.25 0 1 1 1.5 0v1.836A2.493 2.493 0 0 1 6 7h4a1 1 0 0 0 1-1v-.628A2.25 2.25 0 0 1 9.5 3.25Zm-6 0a.75.75 0 1 0 1.5 0 .75.75 0 0 0-1.5 0Zm8.25-.75a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5ZM4.25 12a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5Z"/></svg>`;

            // Expand arrow for branches with children
            const expandArrow = `<span class="lc-tree-branch-arrow">▼</span>`;

            brandEl.innerHTML = `
                <div class="lc-tree-brand-header">
                    <div class="lc-tree-brand-node">${group.brand.charAt(0)}</div>
                    <span class="lc-tree-brand-name">${group.brand}</span>
                    <span class="lc-tree-brand-count">${group.branches.length}</span>
                    <span class="lc-tree-brand-toggle">▼</span>
                </div>
                <div class="lc-tree-branches" style="max-height: ${group.branches.length * 200}px;">
                    ${group.branches.map(branch => `
                        <div class="lc-tree-branch ${branch.current ? 'is-current' : ''} ${branch.children ? 'has-children is-expanded' : ''}"
                             data-role="${branch.name}"
                             data-key="${branch.key}"
                             data-path="${branch.path}"
                             title="${branch.children ? 'Click to expand tests' : 'Click to switch to ' + branch.name}">
                            <span class="lc-tree-branch-icon">${branchIcon}</span>
                            <span class="lc-tree-branch-name">${branch.name}</span>
                            ${branch.current ? '<span class="lc-tree-branch-tag">HEAD</span>' : ''}
                            ${branch.children ? expandArrow : ''}
                        </div>
                        ${branch.children ? `
                            <div class="lc-tree-children is-expanded" data-parent="${branch.key}">
                                ${branch.children.map(child => `
                                    <div class="lc-tree-child"
                                         data-key="${child.key}"
                                         data-path="${child.path}"
                                         data-name="${child.name}"
                                         ${child.test_steps ? `data-test-steps='${JSON.stringify(child.test_steps)}'` : ''}
                                         title="Click to test ${child.name}">
                                        <span class="lc-tree-child-name">${child.name}</span>
                                        ${child.test_steps ? '<span class="lc-child-status-label"></span><span class="gitlab-pie-loader"></span>' : ''}
                                    </div>
                                    ${child.test_steps ? `
                                    <div class="lc-stages-wrap" data-child-key="${child.key}">
                                        <span class="lc-stages-toggle">
                                            <span class="lc-stages-toggle-arrow">▼</span>Stages<span class="lc-stages-percent"></span>
                                        </span>
                                        <div class="lc-stages" data-child-key="${child.key}">
                                            ${child.test_steps.map(step => `
                                                <div class="lc-stage" data-step-id="${step.id}" data-label="${step.label}">
                                                    <span class="lc-stage-tooltip">${step.label}</span>
                                                </div>
                                            `).join('')}
                                        </div>
                                    </div>` : ''}
                                `).join('')}
                            </div>
                        ` : ''}
                    `).join('')}
                </div>
            `;

            // Toggle brand collapse
            const header = brandEl.querySelector('.lc-tree-brand-header');
            header.addEventListener('click', () => {
                const branches = brandEl.querySelector('.lc-tree-branches');
                if (brandEl.classList.contains('is-collapsed')) {
                    // Expanding
                    brandEl.classList.remove('is-collapsed');
                    if (branches) {
                        branches.style.maxHeight = branches.scrollHeight + 'px';
                        // After transition, remove max-height so children can expand freely
                        branches.addEventListener('transitionend', function handler() {
                            branches.removeEventListener('transitionend', handler);
                            if (!brandEl.classList.contains('is-collapsed')) {
                                branches.style.maxHeight = 'none';
                            }
                        });
                    }
                } else {
                    // Collapsing — set max-height to current scrollHeight, then collapse
                    if (branches) {
                        branches.style.maxHeight = branches.scrollHeight + 'px';
                        branches.offsetHeight; // force reflow
                        brandEl.classList.add('is-collapsed');
                    } else {
                        brandEl.classList.add('is-collapsed');
                    }
                }
                fixTreeLines();
            });

            // Click on branch
            brandEl.querySelectorAll('.lc-tree-branch').forEach(branchEl => {
                branchEl.addEventListener('click', (e) => {
                    e.stopPropagation();

                    if (branchEl.classList.contains('has-children')) {
                        // Toggle children expand/collapse
                        const childrenContainer = branchEl.nextElementSibling;
                        if (childrenContainer && childrenContainer.classList.contains('lc-tree-children')) {
                            const isExpanded = childrenContainer.classList.toggle('is-expanded');
                            branchEl.classList.toggle('is-expanded', isExpanded);
                            fixTreeLines();
                        }
                    } else {
                        // No children — checkout directly
                        checkoutRole(branchEl.dataset.role);
                    }
                });
            });

            // Click on child — run test
            brandEl.querySelectorAll('.lc-tree-child').forEach(childEl => {
                childEl.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const path = childEl.dataset.path;
                    const testStepsRaw = childEl.dataset.testSteps;

                    if (testStepsRaw) {
                        // Has test steps → start automated form test
                        const testSteps = JSON.parse(testStepsRaw);
                        childEl.classList.add('is-testing');
                        startAutoTest({
                            key: childEl.dataset.key,
                            name: childEl.dataset.name,
                            path: path,
                            test_steps: testSteps,
                        });
                    } else if (path) {
                        // No test steps → simple URL test
                        runTest(path, childEl);
                    }
                });
            });

            // Click on stages toggle
            brandEl.querySelectorAll('.lc-stages-toggle').forEach(toggle => {
                toggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const wrap = toggle.closest('.lc-stages-wrap');
                    if (wrap) {
                        wrap.classList.toggle('is-expanded');
                        // Update parent branches max-height to fit new content
                        const parentBranches = wrap.closest('.lc-tree-branches');
                        if (parentBranches) parentBranches.style.maxHeight = 'none';
                        fixTreeLines();
                    }
                });
            });

            tree.appendChild(brandEl);
        });

        graphBody.innerHTML = '';
        graphBody.appendChild(tree);

        // Update footer
        graphTotal.textContent = `${data.total} branches`;
        graphCurrent.textContent = data.current ? `HEAD: ${data.current}` : 'No role selected';

        // Restore any saved test results (✓/✕)
        restoreTestResults();

        // Fix vertical tree lines to stop at last child (wait for DOM render)
        requestAnimationFrame(() => fixTreeLines());
    }

    function fixTreeLines() {
        // Fix children vertical lines
        document.querySelectorAll('.lc-tree-children').forEach(container => {
            const children = container.querySelectorAll(':scope > .lc-tree-child');
            if (children.length === 0) return;
            const lastChild = children[children.length - 1];
            const lineHeight = lastChild.offsetTop + lastChild.offsetHeight / 2;
            container.style.setProperty('--line-h', lineHeight + 'px');
        });

        // Fix main vertical line — stop at last brand's last visible element
        document.querySelectorAll('.lc-tree').forEach(tree => {
            const brands = tree.querySelectorAll('.lc-tree-brand');
            if (brands.length === 0) { tree.style.setProperty('--main-line-h', '0px'); return; }

            // Find the target element: last brand's deepest visible point
            const lastBrand = brands[brands.length - 1];
            let target;
            if (lastBrand.classList.contains('is-collapsed')) {
                // Collapsed → line stops at brand header
                target = lastBrand.querySelector('.lc-tree-brand-header');
            } else {
                // Expanded → line stops at last branch inside
                const branches = lastBrand.querySelectorAll('.lc-tree-branch');
                target = branches.length ? branches[branches.length - 1] : lastBrand.querySelector('.lc-tree-brand-header');
            }
            if (!target) { tree.style.setProperty('--main-line-h', '0px'); return; }

            let top = 0;
            let el = target;
            while (el && el !== tree) {
                top += el.offsetTop;
                el = el.offsetParent;
            }
            const lineHeight = top + target.offsetHeight / 2 - 14;
            tree.style.setProperty('--main-line-h', Math.max(0, lineHeight) + 'px');
        });
    }

    async function loadBranches() {
        graphBody.innerHTML = '<div class="lc-graph-loading">Loading branches...</div>';

        try {
            const res = await fetch(API_BASE + '/branches', {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const json = await res.json();

            if (json.success && json.data) {
                branchesData = json.data;
                renderBranchTree(json.data);

                // Always sync sessionStorage with current role from API
                // This ensures the correct role after login/session changes
                if (json.data.current) {
                    sessionStorage.setItem('role', json.data.current);
                    console.log('Synced role in sessionStorage:', json.data.current);
                }
            } else {
                graphBody.innerHTML = '<div class="lc-graph-empty">Failed to load branches</div>';
            }
        } catch (err) {
            console.error('Failed to load branches:', err);
            graphBody.innerHTML = '<div class="lc-graph-empty">Error loading branches</div>';
        }
    }

    async function checkoutRole(role) {
        printLine('> laravel checkout ' + role, 'cmd');

        try {
            const res = await fetch(API_BASE + '/command', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ command: 'checkout ' + role })
            });

            const data = await res.json();

            if (data.success) {
                printLine(data.message, 'success');
                // Animation handled by Reverb event - no reload needed here
            } else {
                printLine(data.message, 'error');
                if (data.hint) printLine(data.hint, 'muted');
            }
        } catch (err) {
            printLine('ERROR: ' + err.message, 'error');
        }

        printLine('');

        // Open panel if not open
        if (!panel.classList.contains('is-open')) {
            openPanel();
        }
    }

    // Search filter
    function filterBranches(query) {
        query = query.toLowerCase().trim();
        const brands = graphBody.querySelectorAll('.lc-tree-brand');

        brands.forEach(brand => {
            const branches = brand.querySelectorAll('.lc-tree-branch');
            let visibleCount = 0;

            branches.forEach(branch => {
                const name = branch.dataset.role.toLowerCase();
                const match = !query || name.includes(query);
                branch.style.display = match ? '' : 'none';
                if (match) visibleCount++;
            });

            // Show/hide brand based on matching branches
            brand.style.display = visibleCount > 0 ? '' : 'none';

            // Expand brand if searching
            if (query && visibleCount > 0) {
                brand.classList.remove('is-collapsed');
            }
        });
    }

    // Collapse/Expand all
    function collapseAll() {
        graphBody.querySelectorAll('.lc-tree-brand:not(.is-collapsed)').forEach(b => {
            const br = b.querySelector('.lc-tree-branches');
            if (br) { br.style.maxHeight = br.scrollHeight + 'px'; br.offsetHeight; }
            b.classList.add('is-collapsed');
        });
        showBody.querySelectorAll('.lc-level').forEach(l => l.classList.add('is-collapsed'));
        fixTreeLines();
    }

    function expandAll() {
        graphBody.querySelectorAll('.lc-tree-brand.is-collapsed').forEach(b => {
            b.classList.remove('is-collapsed');
            const br = b.querySelector('.lc-tree-branches');
            if (br) {
                br.style.maxHeight = br.scrollHeight + 'px';
                br.addEventListener('transitionend', function handler() {
                    br.removeEventListener('transitionend', handler);
                    if (!b.classList.contains('is-collapsed')) {
                        br.style.maxHeight = 'none';
                    }
                });
            }
        });
        showBody.querySelectorAll('.lc-level').forEach(l => l.classList.remove('is-collapsed'));
        fixTreeLines();
    }

    // ===== Fullscreen Commits Mode =====
    const graphColors = ['#e51400', '#00cc6a', '#cc00cc', '#0078d4', '#ff8c00', '#00bcd4', '#9c27b0', '#4caf50'];

    function enterFullscreen(badge = 'All Branches', showHead = false) {
        panel.classList.add('is-fullscreen');

        // Always show current HEAD role from sessionStorage or branchesData
        const currentRole = getCurrentRole();
        graphBadge.textContent = currentRole || badge;

        // Always show HEAD tag when we have a current role
        graphHeadTag.style.display = currentRole ? 'inline-block' : 'none';

        // Open panel if not already open
        if (!panel.classList.contains('is-open')) {
            openGraph();
        }
    }

    function exitFullscreen() {
        panel.classList.remove('is-fullscreen');
        panel.classList.remove('is-expanded');
        panel.classList.remove('is-floating');
        panel.style.top = '';
        panel.style.left = '';
        panel.style.width = '';
        panel.style.height = '';
        // Reset expand button text
        const expandBtn = document.getElementById('lcGraphExpand');
        if (expandBtn) expandBtn.innerHTML = '&#x21c6; Expand';
        const floatBtn = document.getElementById('lcGraphFloat');
        if (floatBtn) { floatBtn.innerHTML = '&#x2750;'; floatBtn.title = 'Float window'; }
        // Reset inline styles so CSS takes over
        graphHeadTag.style.display = '';
    }

    function getCurrentRole() {
        // Priority: sessionStorage > branchesData > DOM element
        const sessionRole = sessionStorage.getItem('role');
        if (sessionRole) {
            return sessionRole;
        }
        if (branchesData && branchesData.current) {
            return branchesData.current;
        }
        const currentEl = graphBody.querySelector('.lc-tree-branch.is-current');
        return currentEl ? currentEl.dataset.role : null;
    }

    // Draw graph line in SVG
    function drawGraphLine(colorIndex, isFirst = false, hasParent = true) {
        const color = graphColors[colorIndex % graphColors.length];
        const cx = 20 + (colorIndex * 15);
        return `
            <svg width="80" height="28" style="display: block;">
                ${hasParent ? `<line x1="${cx}" y1="0" x2="${cx}" y2="14" stroke="${color}" stroke-width="2"/>` : ''}
                <circle cx="${cx}" cy="14" r="4" fill="${color}"/>
                ${!isFirst ? `<line x1="${cx}" y1="14" x2="${cx}" y2="28" stroke="${color}" stroke-width="2"/>` : ''}
            </svg>
        `;
    }

    // Format date to display
    function formatDate(dateStr) {
        const date = new Date(dateStr);
        return date.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    // Render Payment Pipeline rows with 3-level hierarchy (Year > Month > Day)
    function renderPipelines(pipelines, branchName = null) {
        if (!pipelines || pipelines.length === 0) {
            showBody.innerHTML = `
                <div class="lc-show-empty">
                    <span style="color: #888;">No payment data</span>
                </div>
            `;
            return;
        }

        // Filter out role switch entries - only show payment/transaction data
        const filteredPipelines = pipelines.filter(p => {
            const title = (p.title || p.message || '').toLowerCase();
            return !title.includes('switch to') && !title.includes('switch from');
        });

        if (filteredPipelines.length === 0) {
            showBody.innerHTML = `
                <div class="lc-show-empty">
                    <span style="color: #888;">No payment data</span>
                </div>
            `;
            return;
        }

        // Group pipelines by Year > Month > Day
        const grouped = {};
        filteredPipelines.forEach(pipeline => {
            const date = new Date(pipeline.date || Date.now());
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');

            if (!grouped[year]) grouped[year] = {};
            if (!grouped[year][month]) grouped[year][month] = {};
            if (!grouped[year][month][day]) grouped[year][month][day] = [];
            grouped[year][month][day].push(pipeline);
        });

        // Month names
        const monthNames = ['', 'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'];

        // Default stages for payment pipeline
        const defaultStages = ['payment', 'promotion', 'complete'];

        // Render single pipeline item (2-box layout like pipeline-viewer)
        function renderPipelineItem(pipeline, index) {
            const stages = pipeline.stages || defaultStages;
            const stageStatuses = pipeline.stageStatus || {};

            // Determine overall status (failed > running > pending > passed)
            let overallStatus = 'passed';
            for (const stage of stages) {
                const status = stageStatuses[stage] || 'pending';
                if (status === 'failed') { overallStatus = 'failed'; break; }
                if (status === 'running') overallStatus = 'running';
                else if (status === 'pending' && overallStatus !== 'running') overallStatus = 'pending';
            }

            // Stage labels (capitalize first letter)
            const stageLabels = {
                'payment': 'Payment',
                'promotion': 'Promotion',
                'complete': 'Donate',
                'donate': 'Donate'
            };

            const stagesHtml = stages.map((stage, i) => {
                const status = stageStatuses[stage] || 'pending';
                const isLast = i === stages.length - 1;
                const jobName = pipeline.jobs?.[stage] || stage;
                const label = stageLabels[stage] || stage.charAt(0).toUpperCase() + stage.slice(1);

                let stageIcon = '';
                if (status === 'passed') stageIcon = '✓';
                else if (status === 'failed') stageIcon = '✕';
                else if (status === 'running') stageIcon = '⟳';
                else if (status === 'pending') stageIcon = '⟳';
                else if (status === 'skipped') stageIcon = '⏭';

                return `
                    <div class="lc-stage-group">
                        <span class="lc-stage-label">${label}</span>
                        <div class="lc-stage-item">
                            <div class="lc-stage-circle is-${status}" data-stage="${stage}">
                                <span>${stageIcon}</span>
                            </div>
                            <div class="lc-stage-tooltip">
                                <div class="lc-stage-tooltip-header">Stage: ${stage}</div>
                                <div class="lc-stage-tooltip-body">
                                    <div class="lc-stage-tooltip-job" data-job="${jobName}">
                                        <span class="lc-stage-tooltip-icon is-${status}">${stageIcon || '○'}</span>
                                        <span>${jobName}</span>
                                    </div>
                                </div>
                            </div>
                            ${!isLast ? '<div class="lc-stage-arrow"></div>' : ''}
                        </div>
                    </div>
                `;
            }).join('');

            // Format time duration (mock for now)
            const duration = pipeline.duration || '00:00:30';
            const member = pipeline.member || 'walk-in';
            // Calculate total from items, fallback to pipeline.amount
            const itemsTotal = (pipeline.items || []).reduce((sum, item) => sum + Number(item.total || 0), 0);
            const amount = (itemsTotal > 0 ? itemsTotal : Number(pipeline.amount || 0)).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            const invoiceNumber = pipeline.title || pipeline.invoice_number || 'INV-' + (new Date().getFullYear()) + '-' + String(index + 1).padStart(4, '0');

            // Build table box HTML - always show with pipeline data
            const brand = pipeline.brand || 'Brand OP';
            const productCode = pipeline.product_code || pipeline.productCode || '22600';
            const docHeader = pipeline.doc_header || 'หัวข้อเอกสาร';
            const docSubtitle = pipeline.doc_subtitle || '';

            // ─── Build DataTable HTML ───
            const tagStatus = overallStatus === 'passed' ? 'is-passed' : overallStatus === 'running' ? 'is-running' : 'is-pending';
            const tagText = overallStatus === 'passed' ? 'Completed' : overallStatus === 'running' ? 'In Progress' : 'Not Started';
            const tableId = `lc-dt-${pipeline.id || index}`;

            const tableHtml = `
                <div class="lc-pipeline-table">
                    <div class="lc-pipeline-table-header">
                        ${docHeader}
                        ${docSubtitle ? `<span class="lc-table-subtitle">${docSubtitle}</span>` : ''}
                        <span class="lc-pipeline-table-tag ${tagStatus}">${tagText}</span>
                    </div>
                    <table id="${tableId}" class="lc-datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>สินค้า</th>
                                <th>ราคา</th>
                                <th>จำนวน</th>
                                <th>รวม</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    <tfoot><tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-center"></td>
                        <td class="text-right"></td>
                    </tr></tfoot>
                    </table>
                </div>
            `;

            // Store items data for DataTable init after DOM render
            if (!window._lcPipelineTableData) window._lcPipelineTableData = [];
            window._lcPipelineTableData.push({ tableId, items: pipeline.items || [], brand });

            // User info
            const userName = pipeline.user_name || member;
            const userCode = pipeline.user_code || member;
            const userPhone = pipeline.user_phone || '';
            const userEmail = pipeline.user_email || '';
            const loyaltyCard = pipeline.loyalty_card || '';
            const balance = pipeline.balance ? Number(pipeline.balance).toLocaleString('en-US', {minimumFractionDigits: 2}) : '0.00';

            return `
                <div class="lc-pipeline-row is-${overallStatus}" data-id="${pipeline.id || index}">
                    ${tableHtml}
                    <div class="lc-pipeline-stages">
                        ${stagesHtml}
                    </div>
                    <div class="lc-pipeline-bottom">
                        <div class="lc-pipeline-info-user">
                            <div class="lc-pipeline-user-header">
                                <div class="lc-pipeline-user-avatar">👤</div>
                                <div>
                                    <div class="lc-pipeline-user-name">${userName}</div>
                                    <div class="lc-pipeline-user-id">${userCode}</div>
                                </div>
                            </div>
                            ${loyaltyCard ? `<div class="lc-pipeline-user-detail"><span>Loyalty Card</span><span>${loyaltyCard}</span></div>` : ''}
                            <div class="lc-pipeline-user-detail"><span>Balance</span><span>฿ ${balance}</span></div>
                        </div>
                        <div class="lc-pipeline-info">
                            <div class="lc-pipeline-info-header">
                                <span class="lc-pipeline-status ${overallStatus}">${overallStatus.toUpperCase()}</span>
                                <span class="lc-pipeline-time">⏱ ${duration}</span>
                            </div>
                            <div class="lc-pipeline-title">Rcpt #${invoiceNumber}</div>
                            <div class="lc-pipeline-meta">
                                <span class="lc-pipeline-tag member">👤 ${member}</span>
                                <span class="lc-pipeline-tag-price amount" style="margin-left:auto;">Total &nbsp; ฿ ${amount}</span>
                            </div>
                        </div>
                    </div>
                    <div class="lc-pipeline-actions">
                        <button class="lc-pipeline-btn lc-pipeline-btn-cancel" title="ยกเลิกบิล" data-id="${pipeline.id || index}">✕</button>
                        <button class="lc-pipeline-btn" title="View details">⋯</button>
                    </div>
                </div>
            `;
        }

        // Get today's date for comparison
        const today = new Date();
        const todayYear = today.getFullYear();
        const todayMonth = String(today.getMonth() + 1).padStart(2, '0');
        const todayDay = String(today.getDate()).padStart(2, '0');

        // Build 3-level hierarchy HTML
        let hierarchyHtml = '<div class="lc-hierarchy">';
        const years = Object.keys(grouped).sort((a, b) => b - a); // newest first

        years.forEach((year, yearIdx) => {
            const months = Object.keys(grouped[year]).sort((a, b) => b - a);
            const yearTotal = months.reduce((sum, m) =>
                sum + Object.values(grouped[year][m]).reduce((s, d) => s + d.length, 0), 0);
            const isCurrentYear = parseInt(year) === todayYear;
            const yearCollapsed = yearIdx > 0 ? ' is-collapsed' : '';

            hierarchyHtml += `
                <div class="lc-level lc-year${yearCollapsed}" data-year="${year}">
                    <div class="lc-level-header" onclick="toggleLcLevel(this.parentElement)">
                        <div class="lc-level-node">1</div>
                        <div class="lc-level-content">
                            <div class="lc-level-title">${year}</div>
                            <div class="lc-level-subtitle">${yearTotal} transaction${yearTotal > 1 ? 's' : ''}</div>
                        </div>
                        <div class="lc-level-toggle">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                        </div>
                    </div>
                    <div class="lc-level-body">`;

            months.forEach((month, monthIdx) => {
                const days = Object.keys(grouped[year][month]).sort((a, b) => b - a);
                const monthTotal = days.reduce((sum, d) => sum + grouped[year][month][d].length, 0);
                const isCurrentMonth = isCurrentYear && month === todayMonth;
                const monthCollapsed = (yearIdx > 0 || monthIdx > 0) ? ' is-collapsed' : '';

                hierarchyHtml += `
                        <div class="lc-level lc-month${monthCollapsed}" data-month="${month}">
                            <div class="lc-level-header" onclick="toggleLcLevel(this.parentElement)">
                                <div class="lc-level-node">2</div>
                                <div class="lc-level-content">
                                    <div class="lc-level-title">${monthNames[parseInt(month)]} ${year}</div>
                                    <div class="lc-level-subtitle">${monthTotal} transaction${monthTotal > 1 ? 's' : ''}</div>
                                </div>
                                <div class="lc-level-toggle">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                                </div>
                            </div>
                            <div class="lc-level-body">`;

                days.forEach((day, dayIdx) => {
                    const dayPipelines = grouped[year][month][day];
                    const isToday = isCurrentMonth && day === todayDay;
                    const dayCollapsed = (yearIdx > 0 || monthIdx > 0 || dayIdx > 0) ? ' is-collapsed' : '';
                    const dayLabel = isToday ? 'Today' : `${parseInt(day)} ${monthNames[parseInt(month)]}`;

                    hierarchyHtml += `
                                <div class="lc-level lc-day${dayCollapsed}" data-day="${day}">
                                    <div class="lc-level-header" onclick="toggleLcLevel(this.parentElement)">
                                        <div class="lc-level-node">3</div>
                                        <div class="lc-level-content">
                                            <div class="lc-level-title">${dayLabel}</div>
                                            <div class="lc-level-subtitle">${dayPipelines.length} transaction${dayPipelines.length > 1 ? 's' : ''}</div>
                                        </div>
                                        <div class="lc-level-toggle">
                                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                                        </div>
                                    </div>
                                    <div class="lc-level-body">
                                        <div class="lc-day-content">
                                            ${dayPipelines.map((p, i) => renderPipelineItem(p, i)).join('')}
                                        </div>
                                    </div>
                                </div>`;
                });

                hierarchyHtml += `
                            </div>
                        </div>`;
            });

            hierarchyHtml += `
                    </div>
                </div>`;
        });

        hierarchyHtml += '</div>';
        showBody.innerHTML = hierarchyHtml;

        // ─── Initialize DataTables after DOM render ───
        initPipelineDataTables();
    }

    function initPipelineDataTables() {
        if (!window._lcPipelineTableData || !window._lcPipelineTableData.length) return;

        const fmt = (v) => Number(v || 0).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});

        window._lcPipelineTableData.forEach(({ tableId, items, brand }) => {
            const $table = $(`#${tableId}`);
            if (!$table.length) return;

            // Destroy if already initialized
            if ($.fn.DataTable.isDataTable($table)) {
                $table.DataTable().destroy();
            }

            const tableData = items.length > 0
                ? items.map((item, idx) => [
                    idx + 1,
                    item.product_name || '-',
                    item.price || 0,
                    item.qty || 1,
                    item.total || 0
                ])
                : [[1, brand || '-', 0, 0, 0]];

            $table.DataTable({
                data: tableData,
                searching: false,
                paging: false,
                info: true,
                ordering: true,
                order: [[0, 'asc']],
                autoWidth: false,
                language: {
                    info: 'แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ',
                    infoEmpty: 'ไม่มีข้อมูล',
                    emptyTable: 'ไม่มีข้อมูลสินค้า',
                },
                columnDefs: [
                    {
                        targets: 0,
                        orderable: false,
                        className: 'text-center',
                        width: '40px'
                    },
                    {
                        targets: 1,
                        orderable: true,
                    },
                    {
                        targets: 2,
                        orderable: true,
                        className: 'text-right',
                        width: '120px',
                        render: function(data) {
                            return '฿ ' + fmt(data);
                        }
                    },
                    {
                        targets: 3,
                        orderable: true,
                        className: 'text-center',
                        width: '80px',
                    },
                    {
                        targets: 4,
                        orderable: true,
                        className: 'text-right',
                        width: '120px',
                        render: function(data) {
                            return '฿ ' + fmt(data);
                        }
                    }
                ],
                footerCallback: function(row, data, start, end, display) {
                    if (items.length === 0) return;
                    const api = this.api();
                    const totalQty = api.column(3).data().reduce((a, b) => a + Number(b), 0);
                    const totalAmount = api.column(4).data().reduce((a, b) => a + Number(b), 0);

                    // Update existing tfoot cells
                    $(api.column(0).footer()).html(`<span style="font-weight:600;color:#ffc107;">รวมทั้งหมด</span>`);
                    $(api.column(1).footer()).html(`<span style="font-weight:600;color:#ffc107;">(${items.length} รายการ)</span>`);
                    $(api.column(2).footer()).html('');
                    $(api.column(3).footer()).html(`<span style="font-weight:600;color:#ffc107;">${totalQty}</span>`);
                    $(api.column(4).footer()).html(`<span style="font-weight:600;color:#ffc107;">฿ ${fmt(totalAmount)}</span>`);
                }
            });
        });

        // Clear stored data after init
        window._lcPipelineTableData = [];
    }

    // Toggle level expand/collapse
    window.toggleLcLevel = function(levelEl) {
        levelEl.classList.toggle('is-collapsed');
        // Adjust DataTable columns when section becomes visible
        if (!levelEl.classList.contains('is-collapsed')) {
            setTimeout(() => {
                $(levelEl).find('.lc-datatable').each(function() {
                    if ($.fn.DataTable.isDataTable(this)) {
                        $(this).DataTable().columns.adjust();
                    }
                });
            }, 50);
        }
    };

    // Format time ago
    function formatTimeAgo(dateStr) {
        const date = new Date(dateStr);
        const now = new Date();
        const diffMs = now - date;
        const diffMins = Math.floor(diffMs / 60000);
        const diffHours = Math.floor(diffMs / 3600000);
        const diffDays = Math.floor(diffMs / 86400000);

        if (diffMins < 1) return 'just now';
        if (diffMins < 60) return `${diffMins} min ago`;
        if (diffHours < 24) return `${diffHours} hour${diffHours > 1 ? 's' : ''} ago`;
        if (diffDays < 7) return `${diffDays} day${diffDays > 1 ? 's' : ''} ago`;
        return formatDate(dateStr);
    }

    // Mock test data for layout testing (3 bills with different statuses)
    // COMMENTED OUT - Using real data from API
    /*
    const mockPipelines = [
        {
            id: 1,
            title: 'Payment #INV-2026-0001',
            date: new Date().toISOString(),
            member: 'member-001',
            amount: 1500,
            duration: '00:00:29',
            stages: ['payment', 'promotion', 'complete'],
            stageStatus: { payment: 'passed', promotion: 'passed', complete: 'passed' }
        },
        {
            id: 2,
            title: 'Payment #INV-2026-0002',
            date: new Date().toISOString(),
            member: 'member-002',
            amount: 850,
            duration: '00:00:44',
            stages: ['payment', 'promotion', 'complete'],
            stageStatus: { payment: 'passed', promotion: 'failed', complete: 'pending' }
        },
        {
            id: 3,
            title: 'Payment #INV-2026-0003',
            date: new Date().toISOString(),
            member: 'member-003',
            amount: 2100,
            duration: '--:--:--',
            stages: ['payment', 'promotion', 'complete'],
            stageStatus: { payment: 'pending', promotion: 'pending', complete: 'pending' }
        }
    ];
    */

    // Load pipelines for a specific branch (Show button)
    async function loadBranchCommits(branchName) {
        showBody.innerHTML = `
            <div class="lc-show-loading">
                <span style="color: #888;">Loading pipelines...</span>
            </div>
        `;
        enterFullscreen(branchName || 'Loading...', true);

        try {
            const res = await fetch(API_BASE + '/show', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ branch: branchName })
            });
            const data = await res.json();

            if (data.success && (data.pipelines || data.commits)) {
                graphBadge.textContent = branchName;
                // Use real data from API
                const realData = data.pipelines || data.commits;
                renderPipelines(realData, branchName);
            } else {
                // No data available
                graphBadge.textContent = branchName;
                showBody.innerHTML = `
                    <div class="lc-show-empty">
                        <span style="color: #888;">ไม่มีข้อมูลการขาย</span>
                        <small style="color: #666; display: block; margin-top: 8px;">No sales data available</small>
                    </div>
                `;
            }
        } catch (err) {
            console.error('Failed to load pipelines:', err);
            showBody.innerHTML = `
                <div class="lc-show-error">
                    <span style="color: #e57373;">Error loading data: ${err.message}</span>
                </div>
            `;
        }
    }

    // Load all commits (Show All button)
    async function loadAllCommits() {
        showBody.innerHTML = `
            <div class="lc-show-loading">
                <span style="color: #888;">Loading all pipelines...</span>
            </div>
        `;
        enterFullscreen('All Branches');

        try {
            const res = await fetch(API_BASE + '/show-all', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await res.json();

            if (data.success && (data.pipelines || data.commits)) {
                renderPipelines(data.pipelines || data.commits);
            } else {
                showBody.innerHTML = `
                    <div class="lc-show-error">
                        <span style="color: #e57373;">${data.message || 'Failed to load pipelines'}</span>
                    </div>
                `;
            }
        } catch (err) {
            console.error('Failed to load all pipelines:', err);
            showBody.innerHTML = `
                <div class="lc-show-error">
                    <span style="color: #e57373;">Error loading pipelines: ${err.message}</span>
                </div>
            `;
        }
    }

    // ===== Command Execution =====
    async function runCommand() {
        const cmd = terminalInput.value.trim();
        if (!cmd) return;

        commandHistory.push(cmd);
        historyIndex = commandHistory.length;
        try { localStorage.setItem(LC_HISTORY_KEY, JSON.stringify(commandHistory.slice(-50))); } catch(e) {}
        printLine('> ' + cmd, 'cmd');
        terminalInput.value = '';

        // Handle checkout with test_steps — start auto test if child has steps
        const checkoutMatch = cmd.match(/^(?:laravel\s+)?checkout\s+(.+)$/i);
        if (checkoutMatch) {
            const target = checkoutMatch[1].trim();
            // Find matching child element with test_steps
            const childEl = document.querySelector(`.lc-tree-child[data-path="/${target}"], .lc-tree-child[data-key="${target}"]`);
            if (childEl && childEl.dataset.testSteps) {
                const testSteps = JSON.parse(childEl.dataset.testSteps);
                childEl.classList.add('is-testing');
                startAutoTest({
                    key: childEl.dataset.key,
                    name: childEl.dataset.name,
                    path: childEl.dataset.path,
                    test_steps: testSteps,
                });
                return;
            }
            // Also try matching by path directly with leading slash
            const childEl2 = document.querySelector(`.lc-tree-child[data-path="/${target.replace(/^\//, '')}"]`);
            if (childEl2 && childEl2.dataset.testSteps) {
                const testSteps = JSON.parse(childEl2.dataset.testSteps);
                childEl2.classList.add('is-testing');
                startAutoTest({
                    key: childEl2.dataset.key,
                    name: childEl2.dataset.name,
                    path: childEl2.dataset.path,
                    test_steps: testSteps,
                });
                return;
            }
        }

        // Handle show commands directly in frontend
        const showMatch = cmd.match(/^(?:laravel\s+)?show\s+(.+)$/i);
        const showAllMatch = cmd.match(/^(?:laravel\s+)?show\s+--all$/i);

        if (showAllMatch) {
            printLine('Loading all commits...', 'muted');
            loadAllCommits();
            printLine('');
            return;
        }

        if (showMatch && !showAllMatch) {
            const branchName = showMatch[1].trim();
            printLine(`Loading commits for ${branchName}...`, 'muted');
            loadBranchCommits(branchName);
            printLine('');
            return;
        }

        try {
            const res = await fetch(API_BASE + '/command', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ command: cmd })
            });

            const data = await res.json();
            console.log('Laravel Control Response:', data);

            if (data.success) {
                if (data.type === 'branch') {
                    if (data.data && data.data.branches) {
                        printBranches(data.data.branches, data.data.current);
                    } else {
                        printLine('No roles available', 'muted');
                    }
                } else {
                    printLine(data.message, data.type === 'error' ? 'error' : 'success');
                }

                // Checkout animation handled by Reverb event - no reload needed
            } else {
                printLine(data.message, 'error');
                if (data.hint) printLine(data.hint, 'muted');
            }
        } catch (err) {
            printLine('ERROR: ' + err.message, 'error');
        }

        printLine('');
    }

    // ===== Clear test results on refresh (keep only during auto test) =====
    if (!getAutoTestState()) {
        localStorage.removeItem(LC_RESULTS_KEY);
    }

    // ===== Restore panel state from previous page =====
    restorePanelState();

    // ===== Resume automated test if navigated here =====
    // Wait for loadBranches to finish rendering before resuming
    setTimeout(() => resumeAutoTest(), 2500);

    // ===== Event Listeners =====

    // Keyboard shortcuts: Ctrl + ` (Terminal), Ctrl + Shift + ` (Laravel Graph)
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.code === 'Backquote') {
            e.preventDefault();
            if (e.shiftKey) {
                toggleGraph();     // Ctrl + Shift + `
            } else {
                toggleTerminal();  // Ctrl + `
            }
        }
    });

    // Terminal input
    terminalInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            runCommand();
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (historyIndex > 0) {
                historyIndex--;
                terminalInput.value = commandHistory[historyIndex] || '';
            }
        } else if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (historyIndex < commandHistory.length - 1) {
                historyIndex++;
                terminalInput.value = commandHistory[historyIndex] || '';
            } else {
                historyIndex = commandHistory.length;
                terminalInput.value = '';
            }
        } else if (e.key === 'Escape') {
            closeTerminal();
        }
    });

    // Graph search
    graphSearch.addEventListener('input', (e) => filterBranches(e.target.value));

    // Buttons
    btnRun.addEventListener('click', runCommand);
    btnClear.addEventListener('click', clearTerminal);
    btnClose.addEventListener('click', closeTerminal);
    btnGraphClose.addEventListener('click', closeGraph);
    btnGraphRefresh.addEventListener('click', loadBranches);
    btnGraphCollapseAll.addEventListener('click', collapseAll);
    btnGraphExpandAll.addEventListener('click', expandAll);
    btnGraphBack.addEventListener('click', exitFullscreen);

    // Expand button: ขยาย/ย่อ fullscreen panel ให้เต็มจอ (ทับ sidebar)
    const btnGraphExpand = document.getElementById('lcGraphExpand');
    if (btnGraphExpand) {
        btnGraphExpand.addEventListener('click', function() {
            const isExpanded = panel.classList.toggle('is-expanded');
            btnGraphExpand.innerHTML = isExpanded ? '&#x21c6; Collapse' : '&#x21c6; Expand';
            savePanelState();
        });
    }

    // Float button: ย่อเป็นหน้าต่างลอย / กลับ default
    const btnGraphFloat = document.getElementById('lcGraphFloat');
    if (btnGraphFloat) {
        btnGraphFloat.addEventListener('click', function() {
            const isFloating = panel.classList.toggle('is-floating');
            if (isFloating) {
                panel.classList.remove('is-fullscreen', 'is-expanded');
                const expandBtn = document.getElementById('lcGraphExpand');
                if (expandBtn) expandBtn.innerHTML = '&#x21c6; Expand';
                panel.style.top = '80px';
                panel.style.left = (window.innerWidth / 2 - 200) + 'px';
                panel.style.width = '400px';
                panel.style.height = '500px';
                btnGraphFloat.innerHTML = '&#x25A3;';
                btnGraphFloat.title = 'Restore default';
            } else {
                panel.style.top = '';
                panel.style.left = '';
                panel.style.width = '';
                panel.style.height = '';
                btnGraphFloat.innerHTML = '&#x2750;';
                btnGraphFloat.title = 'Float window';
            }
            savePanelState();
        });
    }

        // ─── Drag (header bar) ───
        let isDragging = false;
        let dragOffsetX = 0, dragOffsetY = 0;

        const graphHeader = graph.querySelector('.lc-graph-header');
        graphHeader.addEventListener('mousedown', function(e) {
            if (!panel.classList.contains('is-floating')) return;
            if (e.target.closest('button') || e.target.closest('input')) return;
            isDragging = true;
            dragOffsetX = e.clientX - panel.getBoundingClientRect().left;
            dragOffsetY = e.clientY - panel.getBoundingClientRect().top;
            e.preventDefault();
        });

        // ─── Edge resize (all 4 edges + 4 corners) ───
        let isResizing = false;
        let resizeDir = '';
        let resizeStartX = 0, resizeStartY = 0;
        let resizeStartW = 0, resizeStartH = 0;
        let resizeStartL = 0, resizeStartT = 0;

        panel.querySelectorAll('.lc-float-edge').forEach(edge => {
            edge.addEventListener('mousedown', function(e) {
                if (!panel.classList.contains('is-floating')) return;
                isResizing = true;
                resizeDir = [...this.classList].find(c => c !== 'lc-float-edge') || '';
                const rect = panel.getBoundingClientRect();
                resizeStartX = e.clientX;
                resizeStartY = e.clientY;
                resizeStartW = rect.width;
                resizeStartH = rect.height;
                resizeStartL = rect.left;
                resizeStartT = rect.top;
                e.preventDefault();
                e.stopPropagation();
            });
        });

        document.addEventListener('mousemove', function(e) {
            // Drag
            if (isDragging) {
                // Allow dragging anywhere — keep at least 60px of header strip on-screen
                const panelW = panel.offsetWidth;
                const minGrab = 60; // px of panel that must stay visible (to grab back)
                const x = Math.max(-(panelW - minGrab), e.clientX - dragOffsetX);
                const y = Math.max(-8, e.clientY - dragOffsetY); // allow slightly above viewport
                panel.style.left = x + 'px';
                panel.style.top = y + 'px';
                return;
            }
            // Resize
            if (!isResizing) return;
            const dx = e.clientX - resizeStartX;
            const dy = e.clientY - resizeStartY;
            const minW = 300, minH = 250;
            const dir = resizeDir;

            if (dir.includes('right') || dir === 'right') {
                panel.style.width = Math.max(minW, resizeStartW + dx) + 'px';
            }
            if (dir.includes('bottom') || dir === 'bottom') {
                panel.style.height = Math.max(minH, resizeStartH + dy) + 'px';
            }
            if (dir.includes('left') || dir === 'left') {
                const newW = Math.max(minW, resizeStartW - dx);
                panel.style.width = newW + 'px';
                panel.style.left = (resizeStartL + resizeStartW - newW) + 'px';
            }
            if (dir.includes('top') && dir !== 'top-left' && dir !== 'top-right' || dir === 'top') {
                const newH = Math.max(minH, resizeStartH - dy);
                panel.style.height = newH + 'px';
                panel.style.top = (resizeStartT + resizeStartH - newH) + 'px';
            }
            // Corners with top
            if (dir === 'top-left' || dir === 'top-right') {
                const newH = Math.max(minH, resizeStartH - dy);
                panel.style.height = newH + 'px';
                panel.style.top = (resizeStartT + resizeStartH - newH) + 'px';
            }
        });

        document.addEventListener('mouseup', function() {
            if (isDragging || isResizing) savePanelState();
            isDragging = false;
            isResizing = false;
        });

    // Filter buttons (Day/Month/Year)
    document.querySelectorAll('.lc-filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active from all
            document.querySelectorAll('.lc-filter-btn').forEach(b => b.classList.remove('is-active'));
            // Add active to clicked
            this.classList.add('is-active');

            const filter = this.dataset.filter;
            console.log('Filter by:', filter);

            // Update day separator text based on filter
            const now = new Date();
            if (filter === 'day') {
                updateDaySeparator(now);
            } else if (filter === 'month') {
                showDayText.textContent = now.toLocaleDateString('en-GB', { month: 'long', year: 'numeric' });
                showDayInfo.textContent = 'This month';
            } else if (filter === 'year') {
                showDayText.textContent = now.getFullYear().toString();
                showDayInfo.textContent = 'This year';
            }

            // TODO: Reload pipelines with filter
            // loadPipelinesWithFilter(filter);
        });
    });

    // Cancel bill button (event delegation)
    showBody.addEventListener('click', function(e) {
        const cancelBtn = e.target.closest('.lc-pipeline-btn-cancel');
        if (cancelBtn) {
            const pipelineId = cancelBtn.dataset.id;
            const row = cancelBtn.closest('.lc-pipeline-row');
            const title = row.querySelector('.lc-pipeline-title')?.textContent || 'Bill #' + pipelineId;

            if (confirm(`ยืนยันยกเลิกบิล: ${title}?`)) {
                console.log('Cancel bill:', pipelineId);
                // Add visual feedback
                row.style.opacity = '0.5';
                row.style.pointerEvents = 'none';

                // TODO: Call API to cancel bill
                // cancelBill(pipelineId);

                // For now, just remove the row after animation
                setTimeout(() => {
                    row.style.transition = 'all 0.3s';
                    row.style.transform = 'translateX(-100%)';
                    row.style.opacity = '0';
                    setTimeout(() => row.remove(), 300);
                }, 500);
            }
        }
    });

    // Resizable Terminal (vertical resize within panel)
    let resizingTerminal = false;
    terminalResizer.addEventListener('mousedown', () => resizingTerminal = true);
    document.addEventListener('mousemove', (e) => {
        if (!resizingTerminal) return;
        const panelRect = panel.getBoundingClientRect();
        const h = Math.min(600, Math.max(100, panelRect.bottom - e.clientY));
        document.documentElement.style.setProperty('--lc-terminal-h', h + 'px');
    });
    document.addEventListener('mouseup', () => resizingTerminal = false);

    // Resizable Panel (drag right edge to resize width)
    let resizingPanel = false;
    panelResizer.addEventListener('mousedown', () => resizingPanel = true);
    document.addEventListener('mousemove', (e) => {
        if (!resizingPanel) return;
        const sidebarW = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--lc-sidebar-w'));
        const w = Math.min(800, Math.max(200, e.clientX - sidebarW));
        panel.style.width = w + 'px';
    });
    document.addEventListener('mouseup', () => resizingPanel = false);

    // ===== Laravel Echo / Reverb Integration =====
    function initializeEcho() {
        if (typeof window.Echo === 'undefined') {
            console.warn('Laravel Echo not loaded, skipping initialization');
            return;
        }

        if (!currentUserId) {
            console.warn('User not authenticated, skipping Echo initialization');
            return;
        }

        console.log('Initializing Laravel Control Echo listener for user:', currentUserId);

        // Subscribe to private channel using window.Echo
        window.Echo.private(`laravel-control.${currentUserId}`)
            .listen('.role.switched', function(data) {
                console.log('Role switch event received:', data);

                // Check if panel is open and elements exist
                if (data.fromRole && data.toRole && panel.classList.contains('is-open')) {
                    const fromEl = graphBody.querySelector(`[data-role="${data.fromRole}"]`);
                    const toEl = graphBody.querySelector(`[data-role="${data.toRole}"]`);

                    if (fromEl && toEl) {
                        // Run animation
                        animateGlowPath(data.fromRole, data.toRole);

                        // Update HEAD display after animation completes
                        setTimeout(() => {
                            updateCurrentBranchDisplay(data.toRole);
                        }, 2500);
                    } else {
                        // Elements not found - just update display
                        updateCurrentBranchDisplay(data.toRole);
                    }
                } else if (data.toRole) {
                    // Graph not open - update footer, sessionStorage and navbar
                    graphCurrent.textContent = `HEAD: ${data.toRole}`;
                    updateRoleEverywhere(data.toRole);
                }
            });

        console.log('Successfully subscribed to laravel-control channel');
    }

    // ===== Glow Animation Functions =====
    function animateGlowPath(fromRole, toRole) {
        const fromEl = graphBody.querySelector(`[data-role="${fromRole}"]`);
        const toEl = graphBody.querySelector(`[data-role="${toRole}"]`);

        if (!fromEl || !toEl) {
            console.warn('Could not find elements for animation', fromRole, toRole);
            return;
        }

        // Expand parent brands if collapsed
        const fromBrand = fromEl.closest('.lc-tree-brand');
        const toBrand = toEl.closest('.lc-tree-brand');
        if (fromBrand) fromBrand.classList.remove('is-collapsed');
        if (toBrand) toBrand.classList.remove('is-collapsed');

        // Open panel if closed
        if (!panel.classList.contains('is-open')) {
            openGraph();
        }

        // Calculate timing based on distance (faster)
        const fromRect = fromEl.getBoundingClientRect();
        const toRect = toEl.getBoundingClientRect();
        const verticalDistance = Math.abs(toRect.top - fromRect.top);
        const totalAnimTime = 700 + Math.max(300, verticalDistance / 250 * 1000);

        // Scroll to make both visible
        fromEl.scrollIntoView({ behavior: 'smooth', block: 'center' });

        // Step 1: Glow FROM element
        fromEl.classList.add('glow-from');

        // Step 2: Create traveling dot (follows the tree lines)
        setTimeout(() => {
            createTravelingGlow(fromEl, toEl);
        }, 300);

        // Step 3: Glow TO element (after dot arrives)
        setTimeout(() => {
            toEl.classList.add('glow-to');
            toEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 300 + totalAnimTime);

        // Step 4: Cleanup
        setTimeout(() => {
            fromEl.classList.remove('glow-from');
            toEl.classList.remove('glow-to');
        }, 600 + totalAnimTime + 800);
    }

    function createTravelingGlow(fromEl, toEl) {
        const fromRect = fromEl.getBoundingClientRect();
        const toRect = toEl.getBoundingClientRect();
        const panelRect = panel.getBoundingClientRect();

        // Main vertical line position (17px from left of panel, centered on 2px line)
        const mainLineX = panelRect.left + 17;
        const dotSize = 10;
        const dotOffset = dotSize / 2;

        // Calculate vertical distance for dynamic timing (faster)
        const verticalDistance = Math.abs(toRect.top - fromRect.top);
        const verticalTime = Math.max(0.3, verticalDistance / 250); // faster speed

        // Create glow dot
        const dot = document.createElement('div');
        dot.className = 'lc-glow-dot';
        dot.style.cssText = `
            position: fixed;
            left: ${fromRect.left - dotOffset}px;
            top: ${fromRect.top + fromRect.height / 2 - dotOffset}px;
            width: ${dotSize}px;
            height: ${dotSize}px;
            border-radius: 50%;
            background: #00a55b;
            box-shadow: 0 0 20px 8px rgba(0, 165, 91, 0.9);
            pointer-events: none;
            z-index: 9999;
            transition: left 0.25s ease-in-out, top ${verticalTime}s ease-in-out;
        `;
        document.body.appendChild(dot);

        // Force reflow
        dot.offsetHeight;

        // Step 1: Move left to main vertical line (horizontal) - 0.25s
        dot.style.left = (mainLineX - dotOffset) + 'px';

        // Step 2: Move up/down along main vertical line - dynamic timing
        setTimeout(() => {
            dot.style.top = (toRect.top + toRect.height / 2 - dotOffset) + 'px';
        }, 280);

        // Step 3: Move right to destination branch (horizontal) - 0.25s
        setTimeout(() => {
            dot.style.transition = 'left 0.25s ease-in-out, top 0.25s ease-in-out';
            dot.style.left = (toRect.left - dotOffset) + 'px';
        }, 320 + verticalTime * 1000);

        // Remove dot after animation
        setTimeout(() => {
            dot.remove();
        }, 620 + verticalTime * 1000);
    }

    // ===== Update Session Storage & Navbar =====
    function updateRoleEverywhere(newRole) {
        // Update sessionStorage
        sessionStorage.setItem('role', newRole);

        // Update navbar displays
        const authDepartmantLogin = document.getElementById('auth_departmant_login');
        const authDepartment = document.getElementById('auth_department');

        if (authDepartmantLogin) {
            authDepartmantLogin.innerHTML = `<span class="text-lg font-mono font-bold text-gray-900 dark:text-white">(${newRole})</span>`;
        }
        if (authDepartment) {
            authDepartment.innerHTML = `<span class="text-gray-900 dark:text-white p-2">${newRole}</span>`;
        }

        // Update Sidenav brand theme (if function exists)
        if (typeof window.applySidenavBrandTheme === 'function') {
            window.applySidenavBrandTheme(newRole);
        }

        // Dispatch custom event for other components
        window.dispatchEvent(new CustomEvent('roleChanged', { detail: { role: newRole } }));

        console.log('Role updated everywhere:', newRole);
    }

    function updateCurrentBranchDisplay(newRole) {
        // Update sessionStorage and navbar
        updateRoleEverywhere(newRole);

        // Remove old is-current class
        graphBody.querySelectorAll('.lc-tree-branch.is-current').forEach(el => {
            el.classList.remove('is-current');
            const tag = el.querySelector('.lc-tree-branch-tag');
            if (tag) tag.remove();
        });

        // Add is-current to new role
        const newEl = graphBody.querySelector(`[data-role="${newRole}"]`);
        if (newEl) {
            newEl.classList.add('is-current');
            // Add HEAD tag
            if (!newEl.querySelector('.lc-tree-branch-tag')) {
                const tag = document.createElement('span');
                tag.className = 'lc-tree-branch-tag';
                tag.textContent = 'HEAD';
                newEl.appendChild(tag);
            }
        }

        // Update footer
        graphCurrent.textContent = newRole ? `HEAD: ${newRole}` : 'No role selected';
    }

    // Initialize Echo when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeEcho);
    } else {
        initializeEcho();
    }

    // ===== Floating Tooltip (escape stacking context) =====
    const floatingTooltip = document.getElementById('lcFloatingTooltip');
    const tooltipHeader = document.getElementById('lcTooltipHeader');
    const tooltipBody = document.getElementById('lcTooltipBody');
    let tooltipTimeout = null;
    let isOverTooltip = false;

    // Show floating tooltip on stage hover
    document.addEventListener('mouseover', function(e) {
        const stageCircle = e.target.closest('.lc-stage-circle');
        if (stageCircle) {
            clearTimeout(tooltipTimeout);

            const stageName = stageCircle.dataset.stage || 'stage';
            const status = stageCircle.classList.contains('is-passed') ? 'passed' :
                          stageCircle.classList.contains('is-failed') ? 'failed' :
                          stageCircle.classList.contains('is-running') ? 'running' : 'pending';

            // Get icon based on status
            let icon = '○';
            let iconClass = '';
            if (status === 'passed') { icon = '✓'; iconClass = 'is-passed'; }
            else if (status === 'failed') { icon = '✕'; iconClass = 'is-failed'; }
            else if (status === 'running') { icon = '↻'; iconClass = 'is-running'; }

            // Update tooltip content
            tooltipHeader.textContent = 'Stage: ' + stageName;
            tooltipBody.innerHTML = `
                <div class="lc-stage-tooltip-job">
                    <span class="lc-stage-tooltip-icon ${iconClass}">${icon}</span>
                    <span>${stageName}</span>
                </div>
            `;

            // Position tooltip BELOW the circle (so it doesn't cover labels)
            const rect = stageCircle.getBoundingClientRect();
            floatingTooltip.style.left = (rect.left + rect.width / 2 - 80) + 'px';
            floatingTooltip.style.top = (rect.bottom + 10) + 'px';
            floatingTooltip.classList.add('is-visible');
        }
    });

    // Hide tooltip with delay (to allow moving to tooltip)
    document.addEventListener('mouseout', function(e) {
        const stageCircle = e.target.closest('.lc-stage-circle');
        if (stageCircle) {
            tooltipTimeout = setTimeout(function() {
                if (!isOverTooltip) {
                    floatingTooltip.classList.remove('is-visible');
                }
            }, 100);
        }
    });

    // Keep tooltip visible when mouse is over it
    floatingTooltip.addEventListener('mouseenter', function() {
        isOverTooltip = true;
        clearTimeout(tooltipTimeout);
    });

    // Hide tooltip when mouse leaves it
    floatingTooltip.addEventListener('mouseleave', function() {
        isOverTooltip = false;
        floatingTooltip.classList.remove('is-visible');
    });

    // ===== Expose API =====
    window.LaravelControl = {
        openPanel,
        closePanel,
        togglePanel,
        openTerminal,
        closeTerminal,
        toggleTerminal,
        openGraph,
        closeGraph,
        loadBranches,
        printLine,
        animateGlowPath,
        enterFullscreen,
        exitFullscreen,
        loadBranchCommits,
        loadAllCommits
    };

})();
</script>
