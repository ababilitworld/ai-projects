(() => {
  const body = document.body;
  const book = document.getElementById('book');
  const paperSize = document.getElementById('paperSize');
  const zoomLabel = document.getElementById('zoomLabel');
  const layoutStatus = document.getElementById('layoutStatus');
  const pages = [...document.querySelectorAll('.paper-page')];
  const pageCount = document.getElementById('pageCount');
  const sizeMap = {
    a0: { label: 'A0', page: 'A0 portrait', autoZoom: .22 },
    a4: { label: 'A4', page: 'A4 portrait', autoZoom: .82 },
    a5: { label: 'A5', page: 'A5 portrait', autoZoom: 1.05 }
  };
  let zoom = Number(localStorage.getItem('heartBookZoom')) || sizeMap.a4.autoZoom;

  pages.forEach((page, index) => {
    const folio = page.querySelector('.folio-number');
    if (folio) {
      folio.textContent = `পৃষ্ঠা ${index + 1} / ${pages.length}`;
      folio.dataset.total = pages.length;
    }
  });
  pageCount.textContent = `${pages.length} পৃষ্ঠা`;

  function updatePrintPage(size) {
    let style = document.getElementById('dynamicPageRule');
    if (!style) {
      style = document.createElement('style');
      style.id = 'dynamicPageRule';
      document.head.appendChild(style);
    }
    style.textContent = `@page{size:${sizeMap[size].page};margin:0}`;
  }

  function applyZoom() {
    document.documentElement.style.setProperty('--preview-zoom', zoom);
    zoomLabel.textContent = `${Math.round(zoom * 100)}%`;
    localStorage.setItem('heartBookZoom', zoom);
  }

  function setPaper(size, autoFit = false) {
    body.dataset.paper = size;
    paperSize.value = size;
    localStorage.setItem('heartBookPaper', size);
    updatePrintPage(size);
    if (autoFit) zoom = sizeMap[size].autoZoom;
    applyZoom();
    requestAnimationFrame(checkOverflow);
  }

  function checkOverflow() {
    const overflowed = pages.filter(page => {
      const bodyEl = page.querySelector('.page-body');
      return bodyEl && (bodyEl.scrollHeight > bodyEl.clientHeight + 2 || bodyEl.scrollWidth > bodyEl.clientWidth + 2);
    });
    if (overflowed.length) {
      layoutStatus.textContent = `⚠ ${overflowed.length} পৃষ্ঠায় overflow পাওয়া গেছে`;
      layoutStatus.style.color = '#a91f35';
    } else {
      layoutStatus.textContent = '✓ সব পৃষ্ঠার content সম্পূর্ণ দৃশ্যমান';
      layoutStatus.style.color = '#0f5d45';
    }
  }

  paperSize.addEventListener('change', e => setPaper(e.target.value, true));
  document.getElementById('zoomIn').addEventListener('click', () => { zoom = Math.min(1.5, +(zoom + .05).toFixed(2)); applyZoom(); });
  document.getElementById('zoomOut').addEventListener('click', () => { zoom = Math.max(.12, +(zoom - .05).toFixed(2)); applyZoom(); });
  document.getElementById('resetZoom').addEventListener('click', () => { zoom = sizeMap[body.dataset.paper].autoZoom; applyZoom(); });
  document.getElementById('printBtn').addEventListener('click', () => { checkOverflow(); window.print(); });
  window.addEventListener('load', checkOverflow);
  window.addEventListener('resize', checkOverflow);

  const savedPaper = localStorage.getItem('heartBookPaper') || 'a4';
  setPaper(savedPaper, !localStorage.getItem('heartBookZoom'));
})();
