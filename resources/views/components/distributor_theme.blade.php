<style>
    @import url('https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        --dist-bg: #f9f7f3;
        --dist-card: #ffffff;
        --dist-border: #ece8e5;
        --dist-hero-start: #b84934;
        --dist-hero-end: #822418;
        --dist-primary: #b2352a;
        --dist-primary-dark: #882323;
        --dist-text: #2f2f2f;
        --dist-muted: #68605d;
        --dist-success: #2e7d32;
        --dist-warn: #b88900;
        --dist-info: #5a7fa0;
        --dist-shadow-soft: 0 8px 22px rgba(27, 22, 18, 0.08);
        --dist-shadow-card: 0 10px 26px rgba(29, 33, 28, 0.1);
        --dist-radius-xl: 22px;
        --dist-radius-lg: 16px;
        --dist-radius-md: 12px;
        --dist-space-section: 28px;
    }

    .dist-page {
        background: var(--dist-bg);
        font-family: 'Plus Jakarta Sans', 'Jakarta Sans', sans-serif;
        color: var(--dist-text);
        min-height: 100vh;
        padding: 0;
        display: flex;
        flex-direction: column;
    }

    .dist-page > .dist-shell {
        width: 100%;
        flex: 1;
    }

    .dist-page > footer {
        margin-top: auto !important;
        margin-bottom: 0 !important;
    }

    .dist-page h1,
    .dist-page h2,
    .dist-page h3,
    .dist-page h4,
    .dist-page h5 {
        font-family: 'Fraunces', serif;
        color: #7b2117;
        letter-spacing: 0.01em;
    }

    .dist-shell {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .dist-hero {
        background: linear-gradient(145deg, var(--dist-hero-start), var(--dist-hero-end));
        color: #fff;
        border-radius: var(--dist-radius-xl);
        box-shadow: 0 16px 40px rgba(29, 33, 28, 0.11);
        padding: 1.8rem;
        margin-top: 22px;
        margin-bottom: var(--dist-space-section);
    }

    .dist-hero h1,
    .dist-hero h2,
    .dist-hero h3 {
        margin: 0;
        color: #fff;
    }

    .dist-hero p {
        margin: 8px 0 0;
        color: rgba(255, 255, 255, 0.92);
        line-height: 1.55;
    }

    .dist-hero-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        flex-wrap: wrap;
    }

    .dist-back-link {
        color: #fff;
        text-decoration: none;
        font-weight: 700;
        border: 1px solid rgba(255, 255, 255, 0.45);
        border-radius: 999px;
        padding: 9px 16px;
        transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
    }

    .dist-back-link:hover,
    .dist-back-link:focus-visible {
        background: #fff;
        color: var(--dist-primary-dark);
        border-color: #fff;
        outline: none;
    }

    .dist-card {
        background: var(--dist-card);
        border: 1px solid var(--dist-border);
        border-radius: var(--dist-radius-lg);
        box-shadow: var(--dist-shadow-soft);
    }

    .dist-card-padded {
        padding: 20px;
    }

    .dist-section-title {
        margin: 0 0 14px;
        font-size: 1.35rem;
    }

    .dist-muted {
        color: var(--dist-muted);
    }

    .dist-pill-btn {
        border: none;
        border-radius: 999px;
        padding: 10px 18px;
        font-weight: 700;
        text-decoration: none;
        font-size: 0.9rem;
        cursor: pointer;
        transition: transform 0.16s ease, box-shadow 0.16s ease, filter 0.16s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
    }

    .dist-pill-btn:hover,
    .dist-pill-btn:focus-visible {
        transform: translateY(-1px);
        filter: brightness(1.02);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.16);
        outline: none;
    }

    .dist-pill-btn-primary {
        background: var(--dist-primary);
        color: #fff;
    }

    .dist-pill-btn-success {
        background: var(--dist-success);
        color: #fff;
    }

    .dist-pill-btn-neutral {
        background: #efe7e2;
        color: #543d35;
        border: 1px solid #e3d7d1;
    }

    .dist-pill-btn-warn {
        background: #e8cf82;
        color: #533c00;
    }

    .dist-pill-btn-info {
        background: #cad9e7;
        color: #224766;
    }

    .dist-table-wrap {
        overflow-x: auto;
        border-radius: var(--dist-radius-lg);
        border: 1px solid var(--dist-border);
        background: #fff;
    }

    .dist-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 760px;
    }

    .dist-table th,
    .dist-table td {
        text-align: left;
        padding: 14px 16px;
        border-bottom: 1px solid #f0ece8;
        font-size: 0.92rem;
    }

    .dist-table th {
        background: #f8f4f1;
        color: #50362f;
        font-weight: 700;
    }

    .dist-table tr:hover {
        background: #fffaf6;
    }

    .dist-order-id {
        color: var(--dist-primary);
        font-weight: 800;
    }

    .dist-status-chip {
        display: inline-block;
        border-radius: 999px;
        padding: 5px 12px;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .dist-status-pending {
        background: #f8e9ba;
        color: #6f5700;
    }

    .dist-status-delivered {
        background: #d7edd8;
        color: #1f5b22;
    }

    .dist-status-in-transit {
        background: #dce7f1;
        color: #274d6a;
    }

    .dist-metrics-grid,
    .dist-grid {
        display: grid;
        gap: 16px;
    }

    .dist-metrics-grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        margin-bottom: var(--dist-space-section);
    }

    .dist-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    }

    .dist-metric-card {
        border-radius: var(--dist-radius-lg);
        background: #fff;
        border: 1px solid var(--dist-border);
        box-shadow: var(--dist-shadow-soft);
        padding: 18px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .dist-metric-card:hover,
    .dist-metric-card:focus-visible {
        transform: translateY(-3px);
        box-shadow: var(--dist-shadow-card);
        outline: none;
    }

    .dist-metric-card h4 {
        margin: 0 0 6px;
        color: #7c2a20;
        font-size: 1.02rem;
    }

    .dist-metric-value {
        margin: 0;
        font-weight: 800;
        font-size: 2rem;
        color: var(--dist-primary);
        line-height: 1;
    }

    .dist-filters {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 14px;
    }

    .dist-info-list {
        display: grid;
        gap: 9px;
        margin: 0;
    }

    .dist-info-list p {
        margin: 0;
        color: #3a332f;
    }

    .dist-subtle-banner {
        background: #fff1ea;
        color: #5d352d;
        border: 1px solid #f0d1c5;
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 0.92rem;
        margin-bottom: 16px;
    }

    .dist-distributor-nav {
        position: sticky;
        top: 0;
        z-index: 100;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-bottom: 1px solid #efe8e3;
    }

    .dist-nav-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .dist-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 220px;
    }

    .dist-brand-logo {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--dist-primary);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 0.88rem;
    }

    .dist-brand h2 {
        margin: 0;
        font-size: 1.12rem;
        color: var(--dist-primary);
        line-height: 1;
    }

    .dist-brand small {
        color: #7c2a20;
        font-weight: 700;
        font-size: 0.78rem;
    }

    .dist-nav-links {
        display: flex;
        align-items: center;
        gap: 8px;
        flex: 1;
        justify-content: center;
        flex-wrap: wrap;
    }

    .dist-nav-link {
        color: #5d3e37;
        text-decoration: none;
        font-family: 'Plus Jakarta Sans', 'Jakarta Sans', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 8px 14px;
        border-radius: 999px;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .dist-nav-link:hover,
    .dist-nav-link:focus-visible {
        background: #f6e7e1;
        color: var(--dist-primary-dark);
        outline: none;
    }

    .dist-nav-link.is-active {
        background: transparent;
        color: var(--dist-primary);
        box-shadow: none;
    }

    .dist-nav-link.is-active:hover,
    .dist-nav-link.is-active:focus-visible {
        background: transparent;
        color: var(--dist-primary);
    }

    .dist-brand h2,
    .dist-brand small,
    .dist-nav-logout {
        font-family: 'Plus Jakarta Sans', 'Jakarta Sans', sans-serif;
    }

    .dist-nav-logout {
        background: var(--dist-primary);
        color: #fff;
        text-decoration: none;
        border-radius: 999px;
        padding: 9px 16px;
        font-weight: 700;
        font-size: 0.9rem;
        transition: background-color 0.2s ease;
    }

    .dist-nav-logout:hover,
    .dist-nav-logout:focus-visible {
        background: var(--dist-primary-dark);
        outline: none;
    }

    .dist-status-tracker {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .dist-status-step {
        padding: 12px 14px;
        border-radius: 999px;
        border: 1px solid #d9cec8;
        text-align: center;
        min-width: 128px;
        font-weight: 700;
        background: #f5efea;
        color: #6f615b;
    }

    .dist-status-step--active {
        background: #f3ddd4;
        color: #7e2d22;
        border-color: #e2b7a8;
    }

    @media (max-width: 900px) {
        .dist-shell {
            padding: 0 14px;
        }

        .dist-table {
            min-width: 680px;
        }
    }

    @media (max-width: 700px) {
        .dist-page {
            padding-bottom: 24px;
        }

        .dist-hero {
            padding: 1.25rem;
            border-radius: 16px;
        }

        .dist-hero h1,
        .dist-hero h2 {
            font-size: 1.6rem;
        }

        .dist-card-padded {
            padding: 16px;
        }

        .dist-nav-inner {
            justify-content: center;
        }

        .dist-brand {
            justify-content: center;
            width: 100%;
        }

        .dist-nav-links {
            width: 100%;
            justify-content: center;
        }

        .dist-nav-logout {
            width: 100%;
            text-align: center;
        }
    }
</style>
