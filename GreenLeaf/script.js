function toggleMenu() {
    const navLinks = document.querySelector('.nav-links');
    navLinks.classList.toggle('active');
  }
  
  function toggleTheme() {
    document.body.classList.toggle('dark-theme');
  }

  document.getElementById('plantTipsLink').addEventListener('click', function (e) {
    e.preventDefault(); 
    window.location.href = 'plant_care_tips.html';
  });

  document.getElementById('GardeningLink').addEventListener('click', function (e) {
    e.preventDefault(); 
    window.location.href = 'gardening_guides.html'; 
  });

  document.getElementById('privacyLink').addEventListener('click', function (e) {
    e.preventDefault(); 
    window.location.href = 'privacy.html'; 
  });

  document.getElementById('termLinks').addEventListener('click', function (e) {
    e.preventDefault();
    window.location.href = 'terms.html'; 
  });
