(() => {
  'use strict';
  const body = document.body;
  const book = document.getElementById('book');
  const select = document.getElementById('paperSize');
  const pages = [...document.querySelectorAll('.paper-page')];
  const zoomLabel = document.getElementById('zoomLabel');
  const status = document.getElementById('layoutStatus');
  const pageCount = document.getElementById('pageCount');
  let userZoom = 1;

  const pageRules = {
    a0: '@page{size:A0 portrait;margin:0}',
    a4: '@page{size:A4 portrait;margin:0}',
    a5: '@page{size:A5 portrait;margin:0}'
  };
  const dynamic = document.createElement('style');
  dynamic.id = 'dynamic-page-rule';
  document.head.appendChild(dynamic);

  pages.forEach((page, i) => {
    const n = page.querySelector('.folio-number');
    if (n) n.textContent = `পৃষ্ঠা ${i + 1} / ${pages.length}`;
  });
  pageCount.textContent = `${pages.length} পৃষ্ঠা`;

  function applyZoom() {
    book.style.transform = `scale(${userZoom})`;
    book.style.marginBottom = `${Math.max(50, (userZoom - 1) * book.offsetHeight + 50)}px`;
    zoomLabel.textContent = `${Math.round(userZoom * 100)}%`;
  }

  function validateLayout() {
    const overflowing = [];
    document.querySelectorAll('.page-body').forEach((el, i) => {
      if (el.scrollHeight > el.clientHeight + 2 || el.scrollWidth > el.clientWidth + 2) overflowing.push(i + 1);
    });
    if (overflowing.length) {
      status.textContent = `⚠ Content overflow: page ${overflowing.join(', ')}`;
      status.className = 'layout-bad';
    } else {
      status.textContent = '✓ সব পৃষ্ঠার content সম্পূর্ণ দৃশ্যমান';
      status.className = 'layout-ok';
    }
  }

  function setPaper(size) {
    if (!pageRules[size]) size = 'a4';
    body.dataset.paper = size;
    select.value = size;
    dynamic.textContent = pageRules[size];
    localStorage.setItem('heart-routine-paper', size);
    userZoom = 1;
    applyZoom();
    requestAnimationFrame(validateLayout);
  }

  select.addEventListener('change', e => setPaper(e.target.value));
  document.getElementById('zoomIn').addEventListener('click', () => { userZoom = Math.min(2.2, userZoom + .1); applyZoom(); });
  document.getElementById('zoomOut').addEventListener('click', () => { userZoom = Math.max(.35, userZoom - .1); applyZoom(); });
  document.getElementById('resetZoom').addEventListener('click', () => { userZoom = 1; applyZoom(); });
  document.getElementById('printBtn').addEventListener('click', () => window.print());
  window.addEventListener('beforeprint', () => { dynamic.textContent = pageRules[body.dataset.paper] || pageRules.a4; });
  window.addEventListener('load', validateLayout);
  window.addEventListener('resize', validateLayout);

  setPaper(localStorage.getItem('heart-routine-paper') || 'a4');
})();
