/*************************
*	Tab and Slider
*	Author : 카페인러브
*************************/
$(function(){
	// 탭 & 슬라이더
	$('.slider-control li').on('click', function() {
		if ( !$(this).hasClass('selected') ) {
			var
				index = $(this).index(),
				newIndex = index + 1,
				container = $(this).parent().siblings('.slider'),
				images = container.children(),
				imgWidth = images.outerWidth();

			$(this).addClass('selected').siblings('li').removeClass('selected');
			container.stop(true,false).animate({'left':'-'+ imgWidth*index +'px'},400);
			container.find('li:nth-child(' + newIndex + ')').addClass('active').siblings().removeClass('active');
		}
	});
	$('.tabs-control div').on('click', function() {
		if ( !$(this).hasClass('selected') ) {
			var
				index = $(this).index() + 1,
				contents = $(this).parent().next('.tabs-content'),
				target = contents.children('div:nth-child(' + index + ')');

			$(this).addClass('selected').siblings().removeClass('selected');
			target.show().siblings('div').hide();
		}
	});
});

/**************************************************
*	Infobox fix
*	(Reduces image if larger in height than profile area)
*	Author : 카페인러브
**************************************************/
// 정보상자에서 프로필 세로보다 그림의 세로가 클 때 자동으로 리사이즈
$(function(){
	$('.infobox').each(function(){
		var
			$left = $(this).find('a.image').eq(0),
			$right = $(this).children('.right'),
			leftHeight = $(this).find('a.image:first-child').outerHeight(),
			rightHeight = $right.outerHeight();

		if ( leftHeight > rightHeight ){
			$left.css('height', rightHeight ); // 그림을 리사이즈
		}
	});
});

/*************************
*	{{접기}}
*	Author : 카페인러브
*************************/
$(function(){
	$('.toggle').on('click', function() {
		$(this).toggleClass('visible');
		$(this).children('.toggle-content').slideToggle();
	});
});

/*************************
*	오토 셀렉트
*************************/
function selectThis(el){
	var t = el;

	if (document.getSelection) {
		var s = document.getSelection();
		var r = document.createRange();
		r.selectNodeContents(t);
		s.removeAllRanges();
		s.addRange(r);
	}
	else if (document.selection) {
		var r = document.body.createTextRange();
		r.moveToElementText(t);
		r.select();
	}
}

$(':lang(ja)').on('click', function(){
	selectThis(this);
});
$('.copipe').on('click', function(){
	selectThis(this);
});

/************************
*	네타바레 관련
*	Author : 카페인러브
************************/
$(function(){

	// {{네타 시작}} & {{네타 끝}}
	$('span.netabare').on('click', function() {
		$(this).toggleClass('show');
	});

	// {{네타}}
	var $netabox = $('blockquote.netabare');
	if ( $netabox.length == 0 || mw.config.wgNamespaceNumber == 10 ) return;

	$netabox .each(function(){
		var $self = $(this); // {{네타}}

		// 다음 단락까지 모든 내용을 숨김
		$self.nextAll().each(function() {
			var nexts = this.tagName;
			var stop = ['H2', 'H3', 'H4', 'H5'];

			if ( $.inArray( nexts, stop ) !== -1 ) {
				return false; // stop function
			}
			$(this).addClass('invisible').css('opacity', '0'); // censor spoiler
		});

		// {{네타}}를 클릭하면 해당 내용이 나타남
		$self.on('click', function(){
			$(this).nextUntil($netabox).removeClass('invisible').animate({ opacity: 1 });
			$(this).addClass('expired');
		});
	});
});

/****************************************
*	경고 틀
*	Author : Pecoes, 2012
*	( http://dev.wikia.com/wiki/SpoilerAlert )
*	Personalization : 카페인러브
****************************************/
jQuery(function(){
	window.Censor = (function(){

		// Get current page's Id
		var wgArticleId = (window.mediaWiki && window.mediaWiki.config && window.mediaWiki.config.get('wgArticleId')) || window.wgArticleId;

		// Use LocalStorage
		var ids = localStorage.getItem('censorJS'+wgArticleId);

		// Censoring action
		if ( $('.censor').length && ids != 'valid' ) {

			// Check content type and switch alert message
			if ( $('#netabare').length && $('#mature').length ) {
				var messageType = '이 문서는 네타바레 & 성인용 컨텐츠를 포함하고 있습니다.<br />귀하는 성인이며, 네타바레를 읽으시겠습니까?';
			}
			else if ( $('#netabare').length ) {
				var messageType = '이 문서는 네타바레를 포함하고 있습니다. 문서를 읽으시겠습니까?';
			}
			else if ( $('#mature').length ) {
				var messageType = '이 문서는 성인용 컨텐츠를 포함하고 있습니다. 귀하는 성인입니까?';
			};
			var pageName = wgPageName.split("_").join(" ");
			var dialog =
				'<div id="dialog" class="center">' +
				'<div class="head">' + pageName + '</div>' +
				'<div class="body">' + messageType + '<br>(취소를 누르면 이전 페이지로 이동합니다.)</div>' +
				'<div class="foot">' +
				'<input type="button" id="yes" value="네" />' +
				'<input type="button" id="no" value="아니오"/>' +
				'</div></div>';
			var article = $('div.content');
			var dialogHeight;

			$('<div id="overlay">' + dialog + '</div>').appendTo(article).css({
				position: 'absolute',
				top: 0,
				left: 0,
				right: 0,
				bottom: 0,
				backgroundColor: 'rgba(255,255,255,0.9)',
				minHeight: (dialogHeight = $('#dialog').outerHeight())
			});
			$('#yes').click(function () {
				$('#dialog').remove();
				$('#overlay').fadeOut(1600, function () {
					$(this).remove();
				});
				localStorage.setItem('censorJS'+wgArticleId, 'valid');
			});
			$('#no').click(function () {
				$('#dialog').remove();
				if (history.length) {
					history.back();
				} else {
					location.href = location.protocol + '//' + location.host;
				}
			});
		}
	}) (window.Censor);
});

/*********************************
*	Reference Tooltips
*	Author : Yair_rand (Wikipedia)
*	- RTsettings button disabled
*	- ref box highlight disabled
*********************************/
window.pg || $(document).ready(function ($) {

	// Make sure we are in article, project, or help namespace
	var wgCanonicalNamespace = mw.config.wgCanonicalNamespace;
	if (wgCanonicalNamespace === '' || wgCanonicalNamespace === 'Project' || wgCanonicalNamespace === 'Help') {
		function toggleRT(o) {
			mw.loader.using("jquery.cookie", function () {
				$.cookie("RTsettings", o + "|" + settings[1] + "|" + settings[2], {
					path: "/",
					expires: 90
				});
				location.reload();
			})
		}
		var settings = document.cookie.split("RTsettings=")[1];
		settings = settings ? settings.split(";")[0].split("%7C") : [1, 200, +("ontouchstart" in document.documentElement)];
		var isTouchscreen = +settings[2],
			timerLength = isTouchscreen ? 0 : +settings[1],
			settingsMenu,
			R;
		$(".reference").each(R = function () {
			var tooltipNode, hideTimer, showTimer, checkFlip = false;

			function findRef(h) {
				h = h.firstChild;
				h = h && h.getAttribute && h.getAttribute("href");
				h = h && h.split("#");
				h = h && h[1];
				h = h && document.getElementById(h);
				h = h && h.nodeName == "LI" && h;
				return h;
			}

			function hide(refLink) {
				if (tooltipNode && tooltipNode.parentNode == document.body) {
					hideTimer = setTimeout(function () {
						$(tooltipNode).animate({
							opacity: 0
						}, 100, function () {
							document.body.removeChild(tooltipNode)
						})
					}, isTouchscreen ? 16 : 100)
				} else {
					$(findRef(refLink)).removeClass("RTTarget");
				}
			}

			function show() {
				if (!tooltipNode.parentNode || tooltipNode.parentNode.nodeType === 11) {
					document.body.appendChild(tooltipNode);
					checkFlip = true;
				}
				$(tooltipNode).stop().animate({
					opacity: 1
				}, 100)
				clearTimeout(hideTimer);
			}

			$(this)[isTouchscreen ? 'click' : 'hover'](function (e) {
				var _this = this;
				if (isTouchscreen) {
					e.preventDefault();
					(tooltipNode && tooltipNode.parentNode == document.body) || setTimeout(function () {
						$(document.body).on("click touchstart", function (e) {
							e = e || event;
							e = e.target || e.srcElement;
							for (; e && !$(e).hasClass("referencetooltip");)
								e = e.parentNode;
							if (!e) {
								clearTimeout(showTimer);
								hide(_this);
								$(document.body).off("click touchstart", arguments.callee)
							}
						})
					}, 0);
				}
				hideTimer && clearTimeout(hideTimer);
				showTimer && clearTimeout(showTimer);
				showTimer = setTimeout(function () {
					var h = findRef(_this);
					if (!h) {
						return
					};
					// Hightlight the reference when the ref is entirely on the screen.
					// if (!isTouchscreen && (window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0) + $(window).height() > $(h).offset().top +
					//	h.offsetHeight) {
					//	$(h).addClass("RTTarget");
					//	return;
					// }
					if (!tooltipNode) {
						tooltipNode = document.createElement("ul");
						tooltipNode.className = "referencetooltip";
						var c = tooltipNode.appendChild(h.cloneNode(true));
						$(".reference", c).each(R);
						try {
							if (c.firstChild.nodeName != "A") {
								while (c.childNodes[1].nodeName == "A" && c.childNodes[1].getAttribute("href").indexOf("#cite_ref-") !== -1) {
									do {
										c.removeChild(c.childNodes[1])
									} while (c.childNodes[1].nodeValue == " ");
								}
							}
						} catch (e) {
							mw.log(e)
						}
						c.removeChild(c.firstChild);
						tooltipNode.appendChild(document.createElement("li"));
						isTouchscreen || $(tooltipNode).hover(show, hide);
					}
					show();
					var o = $(_this).offset(),
						oH = tooltipNode.offsetHeight;
					$(tooltipNode).css({
						top: o.top - oH,
						left: o.left - 7
					});
					if (tooltipNode.offsetHeight > oH) { // is it squished against the right side of the page?
						$(tooltipNode).css({
							left: 'auto',
							right: 0
						});
						tooltipNode.lastChild.style.marginLeft = (o.left - tooltipNode.offsetLeft) + "px";
					}
					if (checkFlip) {
						if (o.top < tooltipNode.offsetHeight + (window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0)) { // is part of it above the top of the screen?
							$(tooltipNode).addClass("RTflipped").css({
								top: o.top + 12
							});
						} else if (tooltipNode.className === "referencetooltip RTflipped") { // cancel previous
							$(tooltipNode).removeClass("RTflipped");
						}
						checkFlip = false;
					}
				}, timerLength);
			}, isTouchscreen ? undefined : function () {
				clearTimeout(showTimer);
				hide(this);
			})
		});
	}
});