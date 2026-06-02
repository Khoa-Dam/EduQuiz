

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const pageLoader = document.getElementById('eq-page-loader');

const showPageLoader = () => {
    if (!pageLoader) {
        return;
    }

    pageLoader.classList.remove('hidden');
    pageLoader.classList.add('flex');
    pageLoader.setAttribute('aria-hidden', 'false');
};

const hidePageLoader = () => {
    if (!pageLoader) {
        return;
    }

    pageLoader.classList.add('hidden');
    pageLoader.classList.remove('flex');
    pageLoader.setAttribute('aria-hidden', 'true');
};

const shouldShowLoaderForLink = (link, event) => {
    if (!link || event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
        return false;
    }

    if (link.target === '_blank' || link.hasAttribute('download') || link.getAttribute('aria-disabled') === 'true') {
        return false;
    }

    const href = link.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:') || href === window.location.href) {
        return false;
    }

    const url = new URL(href, window.location.href);
    if (url.origin !== window.location.origin) {
        return false;
    }

    return !(url.pathname === window.location.pathname && url.search === window.location.search && url.hash);
};

document.addEventListener('click', (event) => {
    const link = event.target.closest('a');

    if (shouldShowLoaderForLink(link, event)) {
        showPageLoader();
    }
});

document.addEventListener('submit', (event) => {
    const form = event.target;
    if (!(form instanceof HTMLFormElement)) {
        return;
    }

    const methodOverride = form.querySelector('input[name="_method"]');
    const submitter = event.submitter || form.querySelector('button[type="submit"], input[type="submit"]');
    const isDelete = methodOverride?.value?.toUpperCase() === 'DELETE';

    if (!submitter || submitter.disabled || !isDelete) {
        return;
    }

    submitter.disabled = true;
    submitter.setAttribute('aria-disabled', 'true');

    if (submitter.tagName === 'BUTTON') {
        submitter.textContent = 'Deleting...';
    } else {
        submitter.value = 'Deleting...';
    }
});

window.addEventListener('pageshow', hidePageLoader);
