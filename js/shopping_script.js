
// Swiper js
var swiper = new swiper(".mySwiper", {
  slidesPerView: 1,
  // grabCursor: true,
  loop: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});


// Nav open close
const body = document.querySelector('body'),
navMenu = body.querySelector('.menu-content'),
navOpenBtn = body.querySelector('.navOpen-btn'),
navCloseBtn = navMenu.querySelector('.navClose-btn');

if(navMenu && navOpenBtn){
  navOpenBtn.addEventListener("click", () =>{
    navMenu.classList.add("open");
    body.style.overflowY = "hidden";
  });
}

if(navMenu && navCloseBtn){
  navCloseBtn.addEventListener("click", () =>{
    navMenu.classList.remove("open");
    body.style.overflowY = "scroll";
    const hidden = document.getElementById("subnav");
    const span = document.getElementById("span");
    if (hidden || span){
      hidden.classList.remove("sub-show");
      span.classList.remove("span-show");
    }
  });
}

let userBox = document.querySelector('.user-box');
document.querySelector('#login-icon').onclick = () =>{
  userBox.classList.toggle('active');
  navbar.classList.remove('active');
}

// Department subnavegation
const sub_nav = document.getElementById("depart");
sub_nav.addEventListener('click', function(){
  const visible = document.getElementById("subnav");
  visible.classList.add("sub-show");
  const span = document.getElementById("span");
  span.classList.add("span-show");
});

const span_active = document.getElementById("span");
span_active.addEventListener('click', function(){
  const hidden = document.getElementById("subnav");
  hidden.classList.remove("sub-show");
  const span_ = document.getElementById("span");
  span_.classList.remove("span-show");
});

// Change header bg color
window.addEventListener("scroll", () => {
  const scrollY = window.pageYOffset;
  
  if(scrollY > 5){
    document.querySelector("header").classList.add("header-active");
  }else{
    document.querySelector("header").classList.remove("header-active");
  }
  
  // Scroll up button
  const scrollUpBtn = document.querySelector('.scrollUp-btn');
  
  if(scrollY > 250){
    scrollUpBtn.classList.add("scrollUpBtn-active");
  }else{
    scrollUpBtn.classList.remove("scrollUpBtn-active");
  }
  
  
  // Nav link indicator
  
  const sections = document.querySelectorAll('section[id]');
  sections.forEach(section =>{
    const sectionHeight = section.offsetHeight,
    sectionTop = section.offsetTop - 100;
    
    let navId = document.querySelector(`.menu-content a[href='#${section.id}']`);
    if(scrollY > sectionTop && scrollY <=  sectionTop + sectionHeight){
      navId.classList.add("active-navlink");           
    }else{
      navId.classList.remove("active-navlink");     
    }
    
    navId.addEventListener("click", () => {
      navMenu.classList.remove("open");
      body.style.overflowY = "scroll";
    });
  });
});

// Scroll Reveal Animation
const sr = ScrollReveal({
  origin: 'top',
  distance: '60px',
  duration: 2500,
  delay: 400,
});

// sr.reveal(`.about-details, .time-table`, {origin: 'right'})

sr.reveal(`.section-title, .section-subtitle, .brand-image, .newsletter, 
.logo-content`, {interval:100,});

sr.reveal(`.left`, {origin: 'left'});
sr.reveal(`.right`, {origin: 'right'});


// Search Section





function show(results){
  if(!results.length){
    return search_show.classList.remove('show');
  }
  console.log(results);
  // let id = 0;
  const content = results
  .map((item) => {
    let href = [];
    href = reachable.filter((i) => {
        return i.toLowerCase().includes(item.toLowerCase());
      });
      return `<li id="item_search"><a href='${href}.php' id='search_item'><button class="bttn">${item}</button></a></li>`;
  })
  .join(' ');
  search_show.classList.add("show");
  search_results.innerHTML = `<ul>${content}</ul>`;
}

let searchable = [
  'Section',
  'Shopping',
  'Home',
  'Order in',
  'Orders',
  'Contact',
  'Cart',
];
let reachable = [
  'section',
  'shopping',
  'home',
  'order in',
  'orders',
  'contact',
  'cart',
];

const search_input = document.getElementById('search-input'),
      search_results = document.querySelector('.results'),
      search_show = document.querySelector('.search');
// console.log(search_input);

search_input.addEventListener('keyup', (e)=>{
  let results = [],
  input_value = search_input.value;
  if(input_value.length > 0){
    results = searchable.filter((item) => {
      return item.toLowerCase().includes(input_value.toLowerCase());
    });
  }
  show(results);
});


// // sr.reveal(`.about-imageContent, .menu-items`, {origin: 'left'})