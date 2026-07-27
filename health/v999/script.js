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


  // ---------------- SINGLE A0 COMPOSITE DSLR JPG EXPORT ----------------
  const jpgBtn = document.getElementById('jpgBtn');
  const jpgPanel = document.getElementById('jpgPanel');
  const jpgDpi = document.getElementById('jpgDpi');
  const jpgQuality = document.getElementById('jpgQuality');
  const downloadJpg = document.getElementById('downloadJpg');
  const exportProgress = document.getElementById('exportProgress');
  const exportBar = document.getElementById('exportBar');

  function openJpgPanel() {
    jpgPanel.hidden = false;
    exportProgress.textContent = 'সব ৯টি পৃষ্ঠা নিয়ে A0 poster তৈরির জন্য প্রস্তুত';
    exportBar.style.width = '0%';
  }
  function closeJpgPanel() {
    if (!downloadJpg.disabled) jpgPanel.hidden = true;
  }
  jpgBtn.addEventListener('click', openJpgPanel);
  document.getElementById('closeJpgPanel').addEventListener('click', closeJpgPanel);
  document.getElementById('cancelJpg').addEventListener('click', closeJpgPanel);
  jpgPanel.addEventListener('click', e => { if (e.target === jpgPanel) closeJpgPanel(); });

  function downloadBlob(blob, filename) {
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    a.remove();
    setTimeout(() => URL.revokeObjectURL(url), 30000);
  }

  function canvasToBlob(canvas, quality) {
    return new Promise((resolve, reject) => {
      canvas.toBlob(blob => blob ? resolve(blob) : reject(new Error('JPG encoding failed')), 'image/jpeg', quality);
    });
  }

  async function ensureExporter() {
    if (window.html2canvas) return;
    throw new Error('JPG exporter library load হয়নি। Internet connection চালু রেখে page reload করুন।');
  }

  function buildA0Poster() {
    const old = document.getElementById('a0CompositeStage');
    if (old) old.remove();

    const stage = document.createElement('section');
    stage.id = 'a0CompositeStage';
    stage.className = 'a0-composite-stage';
    stage.setAttribute('aria-hidden', 'true');

    const heading = document.createElement('header');
    heading.className = 'a0-composite-heading';
    heading.innerHTML = '<b>হৃদ্‌স্বাস্থ্য উন্নয়নের দৈনিক রুটিন ও খাদ্য পরিকল্পনা</b><span>সম্পূর্ণ ৯-পৃষ্ঠার A0 রেফারেন্স পোস্টার</span>';
    stage.appendChild(heading);

    const grid = document.createElement('div');
    grid.className = 'a0-composite-grid';
    stage.appendChild(grid);

    pages.forEach((page, index) => {
      const sourceArt = page.querySelector('.page-art');
      const cell = document.createElement('article');
      cell.className = 'a0-composite-cell';
      cell.dataset.page = String(index + 1);

      const clone = sourceArt.cloneNode(true);
      clone.classList.add('a0-composite-page-art');
      clone.style.transform = 'none';
      clone.style.left = '0';
      clone.style.top = '0';
      clone.style.boxShadow = 'none';
      cell.appendChild(clone);
      grid.appendChild(cell);
    });

    document.body.appendChild(stage);

    // Scale every complete 210×297 mm ebook page into its A0 grid cell.
    [...stage.querySelectorAll('.a0-composite-cell')].forEach(cell => {
      const art = cell.querySelector('.a0-composite-page-art');
      const naturalWidth = art.offsetWidth;
      const naturalHeight = art.offsetHeight;
      const availableWidth = cell.clientWidth;
      const availableHeight = cell.clientHeight;
      const scale = Math.min(availableWidth / naturalWidth, availableHeight / naturalHeight);
      art.style.transformOrigin = 'top left';
      art.style.transform = `scale(${scale})`;
      art.style.left = `${(availableWidth - naturalWidth * scale) / 2}px`;
      art.style.top = `${(availableHeight - naturalHeight * scale) / 2}px`;
    });

    return stage;
  }

  async function exportCompositeA0(dpi, quality) {
    await ensureExporter();
    await document.fonts.ready;

    exportProgress.textContent = 'সব ৯টি পূর্ণ পৃষ্ঠা A0 layout-এ সাজানো হচ্ছে…';
    exportBar.style.width = '12%';
    const stage = buildA0Poster();
    await new Promise(resolve => requestAnimationFrame(() => requestAnimationFrame(resolve)));

    const targetWidth = Math.round(841 / 25.4 * dpi);
    const targetHeight = Math.round(1189 / 25.4 * dpi);
    const scale = targetWidth / stage.offsetWidth;

    exportProgress.textContent = `সম্পূর্ণ A0 poster ${targetWidth.toLocaleString()} × ${targetHeight.toLocaleString()} px render হচ্ছে…`;
    exportBar.style.width = '28%';

    const canvas = await window.html2canvas(stage, {
      backgroundColor: '#fffdf7',
      scale,
      width: stage.offsetWidth,
      height: stage.offsetHeight,
      windowWidth: stage.offsetWidth,
      windowHeight: stage.offsetHeight,
      scrollX: 0,
      scrollY: 0,
      useCORS: true,
      allowTaint: false,
      logging: false,
      imageTimeout: 30000,
      removeContainer: true,
      onclone: clonedDoc => {
        const clonedStage = clonedDoc.getElementById('a0CompositeStage');
        if (clonedStage) {
          clonedStage.style.position = 'absolute';
          clonedStage.style.left = '0';
          clonedStage.style.top = '0';
          clonedStage.style.visibility = 'visible';
          clonedStage.style.zIndex = '1';
        }
      }
    });
    exportBar.style.width = '82%';

    let output = canvas;
    if (canvas.width !== targetWidth || canvas.height !== targetHeight) {
      output = document.createElement('canvas');
      output.width = targetWidth;
      output.height = targetHeight;
      const ctx = output.getContext('2d', { alpha: false });
      ctx.fillStyle = '#fffdf7';
      ctx.fillRect(0, 0, targetWidth, targetHeight);
      ctx.drawImage(canvas, 0, 0, targetWidth, targetHeight);
    }

    exportProgress.textContent = 'JPG encode ও download প্রস্তুত হচ্ছে…';
    exportBar.style.width = '92%';
    const blob = await canvasToBlob(output, quality);
    downloadBlob(blob, `heart-routine-complete-9-page-A0-${dpi}dpi-${targetWidth}x${targetHeight}.jpg`);

    stage.remove();
    output.width = 1; output.height = 1;
    if (canvas !== output) { canvas.width = 1; canvas.height = 1; }
    exportBar.style.width = '100%';
  }

  downloadJpg.addEventListener('click', async () => {
    const dpi = Number(jpgDpi.value || 300);
    const quality = Number(jpgQuality.value || .98);
    downloadJpg.disabled = true;
    document.body.classList.add('is-exporting');
    exportBar.style.width = '2%';

    try {
      await exportCompositeA0(dpi, quality);
      exportProgress.textContent = '✓ সব ৯টি page নিয়ে একটি সম্পূর্ণ A0 JPG download হয়েছে';
    } catch (error) {
      console.error(error);
      const stage = document.getElementById('a0CompositeStage');
      if (stage) stage.remove();
      exportProgress.textContent = `⚠ ${error.message || 'Export ব্যর্থ হয়েছে'} — 240 বা 180 DPI দিয়ে আবার চেষ্টা করুন।`;
    } finally {
      downloadJpg.disabled = false;
      document.body.classList.remove('is-exporting');
    }
  });


  setPaper(localStorage.getItem('heart-routine-paper') || 'a4');
})();


// V9 responsive sticky header interactions.
(() => {
  const appHeader = document.getElementById('appHeader');
  const menuToggle = document.getElementById('headerMenuToggle');
  const controls = document.getElementById('headerControls');
  const exerciseMenu = document.getElementById('exerciseMenu');
  const exerciseToggle = document.getElementById('exerciseMenuToggle');
  const progressBar = document.getElementById('headerProgressBar');

  if (!appHeader) return;

  const setControlsOpen = (open) => {
    appHeader.classList.toggle('controls-open', open);
    menuToggle?.setAttribute('aria-expanded', String(open));
  };

  const setExerciseOpen = (open) => {
    exerciseMenu?.classList.toggle('is-open', open);
    exerciseToggle?.setAttribute('aria-expanded', String(open));
  };

  menuToggle?.addEventListener('click', (event) => {
    event.stopPropagation();
    setControlsOpen(!appHeader.classList.contains('controls-open'));
  });

  exerciseToggle?.addEventListener('click', (event) => {
    event.stopPropagation();
    setExerciseOpen(!exerciseMenu.classList.contains('is-open'));
  });

  document.addEventListener('click', (event) => {
    if (controls && !appHeader.contains(event.target)) setControlsOpen(false);
    if (exerciseMenu && !exerciseMenu.contains(event.target)) setExerciseOpen(false);
  });

  document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') return;
    setExerciseOpen(false);
    setControlsOpen(false);
    menuToggle?.focus();
  });

  const updateHeaderState = () => {
    document.body.classList.toggle('header-scrolled', window.scrollY > 24);
    const scrollable = document.documentElement.scrollHeight - window.innerHeight;
    const progress = scrollable > 0 ? Math.min(100, (window.scrollY / scrollable) * 100) : 0;
    if (progressBar) progressBar.style.width = `${progress}%`;
  };

  window.addEventListener('scroll', updateHeaderState, { passive: true });
  window.addEventListener('resize', () => {
    if (window.innerWidth > 1180) setControlsOpen(false);
  });
  updateHeaderState();
})();
