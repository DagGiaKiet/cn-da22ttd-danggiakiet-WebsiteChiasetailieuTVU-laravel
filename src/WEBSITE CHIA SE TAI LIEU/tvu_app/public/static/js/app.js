// TVU Landing App
(function(){
  // Feather icons
  if (window.feather && typeof window.feather.replace === 'function') {
    window.feather.replace();
  }

  // Vanta background
  try {
    if (window.VANTA && typeof window.VANTA.GLOBE === 'function') {
      window.VANTA.GLOBE({
        el: '#vanta-bg',
        mouseControls: true,
        touchControls: true,
        gyroControls: false,
        minHeight: 200.0,
        minWidth: 200.0,
        color: 0x2563eb,
        color2: 0x1d4ed8,
        backgroundColor: 0xf8fafc
      });
    }
  } catch(e) { /* ignore */ }
})();