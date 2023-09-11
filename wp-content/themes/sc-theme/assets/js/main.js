// native js

Fancybox.bind("[data-fancybox]", {});

const iconMenu = document.querySelector('.header__icon');
if (iconMenu) {
	const menuBody = document.querySelector('.header__menu');
	iconMenu.addEventListener("click", function (e) {
		iconMenu.classList.toggle('active');
		menuBody.classList.toggle('active');
		document.querySelector('body').classList.toggle('noScroll')
	});
}

const fs_swiper = new Swiper('.fs__swiper', {
	direction: 'horizontal',
	loop: false,
	speed: 700,
	autoHeight: false,
	watchOverflow: true,
	navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev',
	},
});

var galleryTop = new Swiper('.gallery__top', {
	spaceBetween: 20,
	loop: true,
	loopedSlides: 1,
	centeredSlides: false,
	navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev',
	},
	slidesPerView: 1,
	breakpoints: {
		768: {
			loopedSlides: 3,
			spaceBetween: 20,
		}
	}
});

var galleryThumbs = new Swiper('.gallery__thumbs', {
	spaceBetween: 0,
	navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev',
	},
	centeredSlides: false,
	slidesPerView: 'auto',
	touchRatio: 0.2,
	slideToClickedSlide: true,
	loopedSlides: 1,
	loop: true,
	slidesPerView: 1,
	breakpoints: {
		768: {
			slidesPerView: 3,
			loopedSlides: 3,
			spaceBetween: 20,
		}
	}
	
});

galleryTop.controller.control = galleryThumbs;
galleryThumbs.controller.control = galleryTop;

const tabsButtons = document.querySelectorAll('.tab__button');

tabsButtons.forEach(btn => {
  btn.addEventListener('click', () => {
    const prevActiveItem = document.querySelectorAll('.tab__item.active');
    const prevActiveButton = document.querySelectorAll('.tab__button.active');
    if (prevActiveButton) {
		prevActiveButton.forEach(element => {
			element.classList.remove('active');
		});
    }
    if (prevActiveItem) {
		prevActiveItem.forEach(element => {
			element.classList.remove('active');
		});
    }
    const nextActiveItemId = `#${btn.getAttribute('data-tab')}`;
    const nextActiveItem = document.querySelector(nextActiveItemId);
    btn.classList.add('active');
    nextActiveItem.classList.add('active');
  });
});

// jquery

jQuery(document).ready(function($) {
	$('.accordion__body').slideUp();
	let accordions = $('.accordion');
	$(accordions).each(function (index, accordion) {
		$(accordion).find('.accordion__item').each(function (i, accordionItem) {
			$(accordionItem).find('.accordion__header').click(function(accordionHeader){
				$(accordionHeader.target).toggleClass('active');
				$(accordionHeader.target).siblings('.accordion__body').slideToggle();
			});
		});
	});
})


