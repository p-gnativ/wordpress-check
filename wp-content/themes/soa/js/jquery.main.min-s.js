if (jQuery)(function ($) {
	var menuShown = false;
	var truncateObjs = [], truncateConfig = [];
	var tweetLinkParser;
	var MAX_WIDTH_S = 499 - 20, MAX_WIDTH_M = 767, MAX_WIDTH_L = 959;
	jQuery(function () {
		truncateConfig = [{
			ait_selector: ".boxes-list ul li a",
			max_rows: 2,
			whole_word: false,
			text_span_class: "truncate",
			ellipsis_string: "..."
		}, {
			ait_selector: ".news-list li .truncate-container",
			max_rows: 3,
			whole_word: false,
			text_span_class: "truncate",
			ellipsis_string: "..."
		}, {
			ait_selector: ".cal .cal-day-item",
			max_rows: 2,
			whole_word: false,
			text_span_class: "truncate",
			ellipsis_string: "..."
		}, {
			ait_selector: ".news-list h4",
			max_rows: 1,
			whole_word: false,
			text_span_class: "truncate",
			ellipsis_string: "..."
		}, {
			ait_selector: ".aside .side-holder a",
			max_rows: 2,
			whole_word: false,
			text_span_class: "truncate",
			ellipsis_string: "..."
		}, {
			ait_selector: ".gridcontentelement p",
			max_rows: 8,
			whole_word: false,
			text_span_class: "truncate",
			ellipsis_string: "..."
		}];
		$.each(truncateConfig, function () {
			truncateObjs[truncateObjs.length] = $(this.ait_selector).ThreeDots(this)
		});
		$.each($(".gridcontentelement p"), function () {
			pText = $(this).html();
			$(this).html('<span class="truncate">' + pText + "</span>")
		});
		$.each($(".boxes .linkMore"), function (k) {
			link = $(this).find("a").eq(0).attr("href");
			titleEl = $(this).closest(".holder").find("a.title");
			titleEl.attr("href", link);
			titleEl.removeClass("alt");
			$(this).hide()
		});
		$.each($(".boxes .entry"), function (k) {
			surroundingLi = $(this).closest("li");
			link = surroundingLi.find(".linkMore");
			if (link.length == 0) {
				titleEl = $(this).closest(".holder").find("a.title");
				if (titleEl.attr("href")) {
					titleEl.removeClass("alt")
				}
			}
		});
		if ($(window).innerWidth() > MAX_WIDTH_M) {
			$("img").each(function () {
				largeSrc = $(this).attr("data-largesrc");
				if (largeSrc != "") {
					$(this).attr("src", $(this).attr("data-largesrc"))
				}
			})
		}
		if (isRetina()) {
			$("img").each(function () {
				if ($(this).attr("data-retinasrc")) {
					$(this).attr("src", $(this).attr("data-retinasrc"))
				}
			})
		}
		$(".moveclass").each(function () {
			moveWhere = $(this).attr("data-movewhere");
			if (moveWhere == "sibling") {
				$(this).siblings($(this).attr("data-moveselector")).addClass($(this).attr("data-moveclass"))
			} else {
				if (moveWhere == "parent") {
					$(this).closest($(this).attr("data-moveselector")).addClass($(this).attr("data-moveclass"))
				}
			}
		});
		$(".scroll-table-wrapper").each(function () {
			$(this).append('<img class="leftscroller" alt="Je kunt naar links scrollen" src="/static/touchpresentation/images/scroll-indicator-left.png" /><img class="rightscroller" alt="Je kunt naar rechts scrollen" src="/static/touchpresentation/images/scroll-indicator-right.png" />')
		});
		if ($(window).innerWidth() < MAX_WIDTH_M) {
			$.each($(".c1 p, .boxes-list p"), function () {
				currentPar = $(this);
				linksFound = currentPar.find("a");
				if (linksFound.length > 1) {
					linklist = $('<ul class="generated-links">');
					$.each(linksFound, function () {
						linklist.append($('<li><a href="' + $(this).attr("href") + '">' + $(this).text() + "</a></li>"))
					});
					currentPar.after(linklist)
				} else {
					if (linksFound.length == 1) {
						currentPar.click(function () {
							if ($(this).find("a").attr("target") == "_blank") {
								window.open($(this).find("a").attr("href"))
							} else {
								window.location.href = $(this).find("a").attr("href")
							}
						})
					}
				}
			})
		}
		initOpenClose();
		initSameHeight();
		$("#mainmenu a").each(function () {
			if ($(this).siblings("ul").size() > 0) {
				$(this).addClass("arrowed")
			}
		});
		$(".btn-menu button").click(function (m) {
			var l = $("#menu-container, #sidebar");
			var k = $("#menu-scroller");
			if (menuShown) {
				$("#overlay-fix").children().width("100%");
				$(".main-holder").css("min-height", "");
				l.hide()
			} else {
				$("#overlay-fix").children().width($("#overlay-fix").width());
				l.show()
			}
			levelsDeep = 1;
			activeItem = $("#mainmenu li.active").eq(0);
			if (activeItem) {
				activeItem.parent().children("li").show().find("a").show();
				activeItem.parentsUntil("#mainmenu").show();
				menuFixHeight(activeItem.parent());
				levelsDeep = activeItem.parentsUntil("#mainmenu", "ul").length + 1
			}
			$("#overlay-fix").toggleClass("pushaway");
			if (!menuShown) {
				$(this).addClass("active");
				span = $(this).find("span");
				span.html(span.attr("data-close"));
				$("#content").block({
					message: null,
					overlayCSS: {cursor: "default", opacity: 0.6, "z-index": 100000},
					onBlock: function () {
						if (Modernizr.touch) {
							$(".blockOverlay").on("touchend", function () {
								$(".btn-menu button").click()
							})
						} else {
							$(".blockOverlay").click(function () {
								$(".btn-menu button").click()
							})
						}
					}
				});
				startingOffset = parseInt(k.width()) * levelsDeep;
				endOffset = parseInt(k.width()) * (levelsDeep - 1);
				k.css("left", "-" + startingOffset + "px");
				k.animate({left: "-" + endOffset + "px"}, 400);
				activeItem.parent().find("button").eq(0).focus();
				$("#overlay-fix a, #overlay-fix input, #overlay-fix button, #overlay-fix select, #overlay-fix textarea").attr("tabindex", "-1")
			} else {
				$("#content").unblock();
				$("#sidebar").hide();
				$(this).removeClass("active");
				$("#overlay-fix").unblock();
				span = $(this).find("span");
				span.html(span.attr("data-open"));
				$("#overlay-fix a, #overlay-fix input, #overlay-fix button, #overlay-fix select, #overlay-fix textarea").attr("tabindex", "0")
			}
			g();
			menuShown = !menuShown;
			m.preventDefault()
		});
		$(".btn-home button").click(function () {
			link = $(this).attr("data-href");
			if (link != "") {
				window.location.href = link
			}
		});
		function a() {
			var l = $("a[data-page-id='" + currentPageId + "']");
			var k = $("#webgisMenu");
			if (k.length) {
				l.attr("href", "#");
				l.attr("class", "");
				l.addClass("arrowed");
				l.closest("li").addClass("webgispage");
				k.appendTo(l.closest("li"));
				k.show();
				j()
			}
		}

		a();
		function j() {
			var k = $("#menu-scroller");
			activeItem = $("#mainmenu li.active").eq(0);
			if (activeItem && !activeItem.hasClass("webgispage")) {
				activeItem.parent().children("li").show().find("a").show();
				activeItem.parentsUntil("#mainmenu").show();
				levelsDeep = activeItem.parentsUntil("#mainmenu", "ul").length + 1
			}
			endOffset = parseInt(k.width()) * (levelsDeep - 1);
			k.css("left", "-" + endOffset + "px");
			menuFixHeight(activeItem.parent())
		}

		j();
		$("#mainmenu").on("click", "a", function (k) {
			if ($(this).attr("href") != "" && $(this).attr("href") != "#" && !$(this).hasClass("webgisMenuItem")) {
				return
			}
			if (!$(this).hasClass("lastItem")) {
				relatedEl = $(this).parent();
				subUL = $(this).siblings("ul").eq(0);
				subUL.show();
				menuFixHeight(subUL);
				$("#menu-scroller").animate({left: "-=204px"}, 400, function () {
					g()
				})
			}
			k.preventDefault()
		});
		$("#mainmenu").on("click", "button.menu-back-arrow", function (k) {
			relatedEl = $(this).parent();
			menuFixHeight(relatedEl.parent().parent().parent());
			$("#menu-scroller").animate({left: "+=204px"}, 400, function () {
				relatedElParent = relatedEl.parent();
				relatedElParent.hide();
				g()
			});
			k.preventDefault()
		});
		function g() {
			$("#menu-container a").attr("tabindex", "-1");
			visibleMenu = $("#menu-container ul:visible:last > li > a").attr("tabindex", "0")
		}

		$.each($(".info-opener h2"), function () {
			if ($(this).parent().hasClass("active")) {
				$(this).parent().find(".info-block").show()
			} else {
				$(this).parent().find(".info-block").hide()
			}
			$(this).click(function (k) {
				if ($(document).innerWidth() < MAX_WIDTH_S) {
					$(this).parent().toggleClass("active");
					$(this).parent().find(".info-block").slideToggle();
					k.stopImmediatePropagation()
				}
			})
		});
		var b;
		var f = "";
		$(window).resize(function (k) {
			clearTimeout(b);
			b = setTimeout(function () {
				truncateConfig = [{
					ait_selector: ".gridcontentelement p",
					max_rows: 8,
					whole_word: false,
					text_span_class: "truncate",
					ellipsis_string: "..."
				}];
				$.each(truncateConfig, function () {
					truncateObjs[truncateObjs.length] = $(this.ait_selector).ThreeDots(this)
				});
				asideConfiguration();
				if ($(document).innerWidth() <= MAX_WIDTH_M) {
					$.each($(".container-title a h2"), function () {
						if ($(this).closest(".container-holder").find(".slide-block").hasClass("active")) {
							$(this).closest(".container-holder").addClass("active");
							$(this).closest(".container-holder").find(".slide-block").show()
						} else {
							$(this).closest(".container-holder").removeClass("active");
							$(this).closest(".container-holder").find(".slide-block").hide()
						}
						$(this).click(function (m) {
							if ($(document).innerWidth() < MAX_WIDTH_M) {
								$(this).closest(".container-holder").find(".slide-block").toggleClass("active");
								$(this).closest(".container-holder").toggleClass("active");
								$(this).closest(".container-holder").find(".slide-block").slideToggle();
								m.stopImmediatePropagation()
							}
						})
					})
				}
				if ($(document).innerWidth() <= MAX_WIDTH_M) {
					$.each($(".container-holder .element h2"), function () {
						if ($(this).closest(".element").find(".slide").hasClass("active")) {
							$(this).closest(".element").addClass("active");
							$(this).closest(".element").find(".slide").show()
						} else {
							$(this).closest(".element").removeClass("active");
							$(this).closest(".element").find(".slide").hide()
						}
						$(this).click(function (m) {
							if ($(document).innerWidth() < MAX_WIDTH_M) {
								$(this).closest(".element").find(".slide").toggleClass("active");
								$(this).closest(".element").toggleClass("active");
								$(this).closest(".element").find(".slide").slideToggle();
								m.stopImmediatePropagation()
							}
						})
					})
				}
				if ($(document).innerWidth() < MAX_WIDTH_S && f == "small") {
					return
				}
				if ($(document).innerWidth() > MAX_WIDTH_M) {
					$(".onLargeNoSlider .js-slide-hidden").removeClass("js-slide-hidden").show()
				} else {
					$.each($(".onLargeNoSlider"), function () {
						if (f != "small") {
							$(this).find(".slide").addClass("js-slide-hidden").hide()
						}
					})
				}
				if ($(document).innerWidth() > MAX_WIDTH_S) {
					$.each($(".info-opener h2"), function () {
						$(this).parent().addClass("active").click(function () {
						});
						$(this).parent().find(".info-block").show()
					})
				}
				if ($(document).innerWidth() > MAX_WIDTH_L) {
					if (menuShown) {
						$(".btn-menu button").click();
						$("#sidebar").show();
						menuShown = false
					} else {
						$("#sidebar").show();
						j()
					}
				} else {
					if (menuShown) {
						$("#sidebar").show()
					} else {
						$("#sidebar").hide()
					}
				}
				if ($(document).innerWidth() > MAX_WIDTH_S) {
					$.each($(".content-holder h2"), function () {
						$(this).addClass("elementsExpanded");
						if (!$(this).hasClass("formh2")) {
							nextEl = $(this).nextAll();
							var m = false;
							$.each(nextEl, function () {
								if ($(this).is("h2") || ($(this).is("form") && $(this).find("h2"))) {
									m = true
								}
								if (!m) {
									$(this).show()
								}
							})
						}
					});
					$.each($(".content-holder h3"), function () {
						if ($(this).prev("h2").length == 0) {
							nextEl = $(this).nextAll();
							var m = false;
							$.each(nextEl, function () {
								if ($(this).is("h2") || $(this).is("h3") || ($(this).is("form") && $(this).find("h2"))) {
									m = true
								}
								if (!m) {
									$(this).show()
								}
							})
						}
					})
				} else {
					$.each($(".content-holder h2"), function () {
						if (!$(this).hasClass("formh2")) {
							if (!$(this).hasClass("alwaysExpanded")) {
								$(this).removeClass("elementsExpanded");
								nextEl = $(this).removeClass("open").nextAll();
								var m = false;
								$.each(nextEl, function () {
									if ($(this).is("h2") || ($(this).is("form") && $(this).find("h2"))) {
										m = true
									}
									if (!m) {
										$(this).removeClass("open").hide()
									}
								})
							} else {
								$(this).addClass("open")
							}
						}
					});
					$.each($(".content-holder h3"), function () {
						if ($(this).prev("h2").length == 0) {
							nextEl = $(this).removeClass("open").nextAll();
							var m = false;
							$.each(nextEl, function () {
								if ($(this).is("h2") || $(this).is("h3") || ($(this).is("form") && $(this).find("h2"))) {
									m = true
								}
								if (!m) {
									$(this).removeClass("open").hide()
								}
							})
						}
					})
				}
				updateTruncation();
				$(".scroll-table-body").scroll();
				calObjs = $(".cal");
				if (calObjs.width() < 480 && !calObjs.hasClass("shorthand")) {
					calObjs.addClass("shorthand");
					$.each($(".cal thead th"), function (n, m) {
						$(this).text($(this).attr("data-shorthand"))
					})
				} else {
					if (calObjs.width() > 480 && calObjs.hasClass("shorthand")) {
						$.each($(".cal thead th"), function (n, m) {
							$(this).text($(this).attr("data-fullversion"))
						});
						calObjs.removeClass("shorthand")
					}
				}
				var l = ["#footer nav.menu li", "#footer .add-nav li"];
				$.each(l, function (n, m) {
					$(m + ".hideSeperator").removeClass("hideSeperator");
					var o = 0;
					$(m).each(function () {
						if ($(this).offset().top != o) {
							$(this).addClass("hideSeperator");
							o = $(this).offset().top
						}
					})
				});
				asideConfiguration();
				if ($("#stuurdoor-container").is(":visible")) {
					modal()
				}
				f = $(document).innerWidth() < MAX_WIDTH_S ? "small" : "notsmall"
			}, 200)
		});
		$(".send-to-email").click(function (k) {
			$(".send-to-email-form").toggle();
			k.preventDefault()
		});
		$(".open-language-list").click(function (k) {
			$(".language-list").slideToggle(400);
			$(this).toggleClass("active");
			k.preventDefault()
		});
		$.each($(".content-holder h2"), function () {
			if (!$(this).hasClass("formh2")) {
				if (!$(this).hasClass("alwaysExpanded")) {
					$(this).removeClass("elementsExpanded");
					if ($(this).parent().is("a")) {
						cnt = $(this).parent().contents();
						$(this).parent().replaceWith(cnt)
					}
					nextEl = $(this).nextAll();
					searchFor = $(this).prop("tagName");
					var k = false;
					$.each(nextEl, function () {
						if ($(this).is(searchFor) || $(this).is("h3") || $(this).is("h2") || ($(this).is("form") && $(this).find("h2"))) {
							k = true
						}
						if (!k) {
							$(this).addClass("collapse-under-header").hide()
						}
					})
				} else {
					$(this).addClass("open")
				}
			}
		});
		$.each($(".content-holder h3"), function () {
			if ($(this).parent("h2").length == 0) {
				nextEl = $(this).nextAll();
				var k = false;
				$.each(nextEl, function () {
					if ($(this).is("h3") || $(this).is("h2") || ($(this).is("form") && $(this).find("h2"))) {
						k = true
					}
					if (!k) {
						$(this).addClass("collapse-under-header").hide()
					}
				})
			}
			if ($(this).parent().is("a")) {
				cnt = $(this).parent().contents();
				$(this).parent().replaceWith(cnt)
			}
			if ($(document).innerWidth() > MAX_WIDTH_S) {
				$(this).show()
			}
		});
		$(".content-holder h2").click(function () {
			if (!$(this).hasClass("formh2")) {
				if ($(document).innerWidth() > MAX_WIDTH_S) {
					return
				}
				nextEl = $(this).nextAll();
				searchFor = $(this).prop("tagName");
				var l = false;
				var k = false;
				if ($(this).hasClass("open")) {
					$.each(nextEl, function () {
						if ($(this).is("h2") || ($(this).is("form") && $(this).find("h2"))) {
							l = true
						}
						if (!l) {
							$(this).removeClass("open").slideUp(400)
						}
					})
				} else {
					$.each(nextEl, function () {
						if ($(this).is("h2") || ($(this).is("form") && $(this).find("h2"))) {
							l = true
						}
						if ($(this).is("h3")) {
							k = true
						}
						$(this).find(".leftscroller, .rightscroller").hide();
						if (!l && (!k || $(this).is("h3"))) {
							$(this).slideToggle(400, function () {
								$(this).find(".scroll-table-body").scroll();
								updateTruncation()
							})
						}
					})
				}
				$(this).toggleClass("open")
			}
		});
		$(".content-holder h3").click(function () {
			if ($(document).innerWidth() > MAX_WIDTH_S) {
				return
			}
			nextEl = $(this).nextAll();
			searchFor = $(this).prop("tagName");
			var k = false;
			$(this).toggleClass("open");
			$.each(nextEl, function () {
				if ($(this).is("h3") || $(this).is("h2") || ($(this).is("form") && $(this).find("h2"))) {
					k = true
				}
				$(this).find(".leftscroller, .rightscroller").hide();
				if (!k) {
					$(this).slideToggle(400, function () {
						$(this).find(".scroll-table-body").scroll();
						updateTruncation()
					})
				}
			})
		});
		$(".image-slider-list").flexslider({
			animation: "slide",
			slideshow: false,
			touch: true,
			directionNav: false,
			controlNav: true,
			pausePlay: true,
			pauseText: "Pauzeer",
			playText: "Speel af"
		});
		$("#fotoalbum-slider").flexslider({
			animation: "slide",
			controlNav: false,
			animationLoop: false,
			slideshow: false,
			sync: "#fotoalbum-carousel",
			touch: true,
			smoothHeight: true,
			start: function (k) {
				activeImage = $(k.slides[k.currentSlide]).find("img");
				$(".fotoalbum-slide-counter .fotoalbum-count-all").text(k.count);
				$(".fotoalbum-slide-counter .fotoalbum-current-count").text(k.currentSlide + 1);
				$(".fotoalbum-current-caption").text(activeImage.attr("title"));
				$(".fotoalbum-enlarge").attr("href", activeImage.attr("src"))
			},
			after: function (k) {
				activeImage = $(k.slides[k.currentSlide]).find("img");
				$(".fotoalbum-slide-counter .fotoalbum-current-count").text(k.currentSlide + 1);
				$(".fotoalbum-current-caption").text(activeImage.attr("title"));
				$(".fotoalbum-enlarge").attr("href", activeImage.attr("src"))
			}
		});
		$("#fotoalbum-carousel").flexslider({
			animation: "slide",
			controlNav: false,
			directionNav: false,
			animationLoop: false,
			slideshow: false,
			asNavFor: "#fotoalbum-slider",
			itemWidth: 135
		});
		if (!Modernizr.inputtypes.date || !Modernizr.touch) {
			$("input[type=date]").each(function () {
				var l = $(this);
				var m = $('<input type="text" />');
				var k = l.prop("attributes");
				$.each(k, function () {
					$.each(k, function () {
						if (this.name != "type") {
							m.attr(this.name, this.value)
						}
					});
					l.replaceWith(m);
					m.datepicker({
						changeMonth: true,
						changeYear: true,
						showOtherMonths: true,
						minDate: l.attr("min"),
						maxDate: l.attr("max")
					})
				})
			});
			$(".datepicker-trigger").click(function (k) {
				dp = $($(this).attr("data-showDatepicker"));
				if (dp.datepicker("widget").is(":empty") || dp.datepicker("widget").is(":hidden")) {
					dp.focus()
				} else {
					dp.blur()
				}
				k.preventDefault()
			})
		}
		var e = $("#Regelgeving_geldendop");
		if (e.length > 0) {
			if (Modernizr.touch && Modernizr.inputtypes.date) {
				var h = $('<input type="date" />');
				var d = e.prop("attributes");
				$.each(d, function () {
					if (this.name != "type") {
						h.attr(this.name, this.value)
					}
				});
				e.replaceWith(h)
			} else {
				$("#Regelgeving_geldendop").datepicker({changeMonth: true, changeYear: true, showOtherMonths: true})
			}
		}
		$(".radio-as-button").change(function () {
			$("input[name=" + $(this).attr("name") + "]").parent().removeClass("active");
			$(this).parent().addClass("active")
		});
		$(".scroll-table-body").scroll(function () {
			var n = $(this).scrollLeft();
			var k = $(this).innerWidth();
			var m = $(this).find(".scroll-table-inner").innerWidth();
			var l = $(this).parent().find(".leftscroller"), o = $(this).parent().find(".rightscroller");
			if (k >= m) {
				l.hide();
				o.hide();
				return
			}
			l.show();
			o.show();
			if (n == 0) {
				o.hide()
			} else {
				if (n + k >= m) {
					l.hide()
				}
			}
		});
		$(".cal-day-item").click(function (l) {
			if ($(".cal").hasClass("shorthand")) {
				showDayEvents($(this).parent().parent());
				l.preventDefault();
				return false
			}
			var k = $(this);
			tooltip = $("#tooltip");
			$("#tooltip .title").text($(this).attr("data-originalspan"));
			$("#tooltip .timeslot").text($(this).attr("data-timeslot"));
			tooltip.show();
			tooltip.position({
				my: "left+10px middle",
				at: "right middle",
				of: k,
				collision: "flip flip",
				using: function (p, m) {
					var n = $(this), q = p.top, o = "switch-" + m.horizontal;
					n.css({left: p.left + "px", top: q + "px"}).removeClass(function (r, s) {
						return (s.match(/\bswitch-\w+/g) || []).join(" ")
					}).addClass(o)
				}
			});
			tooltip.attr("href", $(this).attr("href"));
			tooltip.focus();
			l.preventDefault();
			return false
		});
		$("#tooltip").focusout(function (k) {
			setTimeout(function () {
				$("#tooltip").hide()
			}, 100)
		});
		$(".cal-day-number").click(function () {
			if ($(".cal").hasClass("shorthand") && $(this).siblings().length > 0) {
				showDayEvents($(this).parent());
				return
			}
		});
		$(".modallink").click(function () {
			$("#stuurdoor-container").show();
			resizemodal();
			$(".modal form:first-child input[type=text]").eq(0).focus();
			return false
		});
		$(".search-box .search-input").keyup(function () {
			if ($(this).val() != "") {
				$($(this).attr("data-activate")).addClass("active")
			} else {
				$($(this).attr("data-activate")).removeClass("active")
			}
		});
		$(".leaveMessage .cancel").click(function () {
			$(".leaveMessage, .leaveMessageOverlay").hide();
			$("a, textarea, input, button, select").attr("tabindex", "0");
			$(".leaveMessage button").attr("tabindex", "-1")
		});
		$(".leaveMessage .ok").click(function () {
			$(".leaveMessage, .leaveMessageOverlay").hide();
			location.href = $(this).attr("href")
		});
		$(".hint").aToolTip({
			clickIt: true,
			toolTipId: "hint-tooltip",
			closeTipBtn: "hint-info-close",
			onShow: function () {
				$(".leaveMessageOverlay").show()
			},
			onHide: function () {
				$(".leaveMessageOverlay").hide()
			}
		});
		$(".cookie-foldtoggle, .info-button .cookie-button-link").click(function (k) {
			plusMinusLink = $(this);
			relatedList = $(this).attr("data-infoList");
			if ($(this).hasClass("cookie-button-link")) {
				plusMinusLink = $(".info-button .cookie-foldtoggle");
				relatedList = plusMinusLink.attr("data-infoList")
			}
			if ($(document).innerWidth() <= MAX_WIDTH_M) {
				listEl = $("#" + relatedList);
				if (plusMinusLink.hasClass("closed")) {
					listEl.show();
					plusMinusLink.removeClass("closed")
				} else {
					listEl.hide();
					plusMinusLink.addClass("closed")
				}
			} else {
				if (relatedList == "cookie-more-info") {
					listEl = $("#cookie-more-info");
					if (plusMinusLink.hasClass("closed")) {
						$("#cookie-more-info, #cookie-reject-info, #cookie-accept-info").show();
						plusMinusLink.removeClass("closed")
					} else {
						$("#cookie-more-info, #cookie-reject-info, #cookie-accept-info").hide();
						plusMinusLink.addClass("closed")
					}
				}
			}
			k.preventDefault()
		});
		if ($(document).innerWidth() < MAX_WIDTH_M) {
			$(".info-button .cookie-foldtoggle").removeClass("closed")
		}
		$(".close-cookies").click(function () {
			$($(this).attr("data-closeelement")).slideUp()
		});
		$(".find-more-results").click(function (k) {
			resultList = $($(this).attr("data-resultlist"));
			resultLocation = $(this).attr("data-resultslocation");
			clickedLink = $(this);
			$.getJSON(resultLocation, function (l) {
				for (i in l.results) {
					c = l.results[i];
					head = $("<h3/>").append($("<a/>").attr("href", c.location).text(c.title));
					body = $("<p/>").html($("<div/>").html(c.summary).text());
					$("<li/>").append(head).append(body).appendTo(resultList)
				}
				if (!l.hasOwnProperty("nextResults") || l.nextResults == "") {
					clickedLink.closest("footer").hide()
				} else {
					clickedLink.attr("data-resultslocation", l.nextResults)
				}
			});
			k.preventDefault();
			return false
		});
		$(".find-more-mediaitems").click(function (k) {
			resultList = $($(this).attr("data-resultlist"));
			resultLocation = $(this).attr("data-resultslocation");
			clickedLink = $(this);
			$.getJSON(resultLocation, function (l) {
				for (i in l.results) {
					c = l.results[i];
					if (c.hasImage == "true") {
						image = $("<img/>").attr({alt: c.altText, src: c.imageLocation});
						header = $("<h4/>").append($("<span/>").attr("class", "truncate").text(c.title));
						content = $("<span/>").attr("class", "truncate-container").append($("<span/>").attr("class", "truncate").html((c.summary)));
						link = $("<a/>").attr("href", c.location).append(header).append(image).append(content);
						$("<li/>").append(link).appendTo(resultList)
					} else {
						header = $("<h4/>").append($("<span/>").attr("class", "truncate").text(c.title));
						content = $("<span/>").attr("class", "truncate-container").append($("<span/>").attr("class", "truncate").html((c.summary)));
						link = $("<a/>").attr("href", c.location).append(header).append(content);
						$("<li/>").attr("class", "newsnoimage").append(link).appendTo(resultList)
					}
				}
				truncateConfig = [{
					ait_selector: ".news-list li .truncate-container",
					max_rows: 3,
					whole_word: false,
					text_span_class: "truncate",
					ellipsis_string: "..."
				}, {
					ait_selector: ".news-list h4",
					max_rows: 1,
					whole_word: false,
					text_span_class: "truncate",
					ellipsis_string: "..."
				},];
				$.each(truncateConfig, function () {
					truncateObjs[truncateObjs.length] = $(this.ait_selector).ThreeDots(this)
				});
				if (!l.hasOwnProperty("nextResults") || l.nextResults == "") {
					clickedLink.closest("footer").hide()
				} else {
					clickedLink.attr("data-resultslocation", l.nextResults)
				}
			});
			k.preventDefault();
			return false
		});
		if ($("#stuurdoor-container span.error").length > 0) {
			$("#stuurdoor-container").show()
		}
		tweetLinkParser = setInterval(function () {
			fixTweetLinks()
		}, 500);
		$(".print").click(function () {
			window.print()
		});
		$(window).resize()
	});
	function asideConfiguration() {
		var a = $("aside.aside").attr("id");
		if ($(document).innerWidth() < MAX_WIDTH_M) {
			if ($("#asideSubstitute").length == 0 && $("#" + a).length != 0) {
				var d = $("#" + a).html();
				if (a == "bottomPosition") {
					var b = '<div id="asideSubstitute" class="content-holder">' + d + "</div>";
					$(".result-holder").append(b)
				} else {
					if (a == "topPosition") {
						var e = '<div id="asideSubstitute">' + d + "</div>";
						$(e).insertAfter(".leadText")
					}
				}
			}
			if ($(document).innerWidth() > (MAX_WIDTH_S)) {
				$.each($("#asideSubstitute .itemBlock h2"), function () {
					$(this).addClass("elementsExpanded");
					nextEl = $(this).nextAll();
					var f = false;
					$.each(nextEl, function () {
						if ($(this).is("h2") || ($(this).is("form") && $(this).find("h2"))) {
							f = true
						}
						if (!f) {
							$(this).show()
						}
					})
				});
				$.each($("#asideSubstitute .unit h2"), function () {
					$(this).addClass("elementsExpanded");
					nextEl = $(this).nextAll();
					var f = false;
					$.each(nextEl, function () {
						if ($(this).is("h2") || ($(this).is("form") && $(this).find("h2"))) {
							f = true
						}
						if (!f) {
							$(this).show()
						}
					})
				})
			} else {
				$.each($("#asideSubstitute h2"), function () {
					$(this).removeClass("elementsExpanded");
					if ($(this).parent().is("a")) {
						cnt = $(this).parent().contents();
						$(this).parent().replaceWith(cnt)
					}
					if (!$(this).hasClass("formh2")) {
						nextEl = $(this).nextAll();
						searchFor = $(this).prop("tagName");
						var f = false;
						if ($(document).innerWidth() > MAX_WIDTH_S) {
							return
						}
						$.each(nextEl, function () {
							if ($(this).is(searchFor)) {
								f = true
							}
							if (!f) {
								$(this).addClass("collapse-under-header").hide()
							}
						})
					}
				})
			}
			$("#asideSubstitute h2").click(function (h) {
				if (!$(this).hasClass("formh2")) {
					if ($(document).innerWidth() > MAX_WIDTH_S) {
						return
					}
					$(this).removeClass("elementsExpanded");
					nextEl = $(this).nextAll();
					searchFor = $(this).prop("tagName");
					var g = false;
					var f = false;
					if ($(this).hasClass("open")) {
						$.each(nextEl, function () {
							if ($(this).is("h2") || ($(this).is("form") && $(this).find("h2"))) {
								g = true
							}
							if (!g) {
								$(this).removeClass("open").slideUp(400)
							}
						})
					} else {
						$.each(nextEl, function () {
							if ($(this).is("h2") || ($(this).is("form") && $(this).find("h2"))) {
								g = true
							}
							if ($(this).is("h3")) {
								f = true
							}
							$(this).find(".leftscroller, .rightscroller").hide();
							if (!g && (!f || $(this).is("h3"))) {
								$(this).slideToggle(400, function () {
									$(this).find(".scroll-table-body").scroll();
									updateTruncation()
								})
							}
						})
					}
					$(this).toggleClass("open")
				}
				h.stopImmediatePropagation()
			})
		}
		if ($("#asideSubstitute").length != 0 && $("#" + a).length != 0) {
			if ($("aside.aside").is(":visible")) {
				$("#asideSubstitute").remove()
			}
		}
	}

	function fixTweetLinks() {
		if ($(".boxes-list .tweet_list").children().length > 0 && $(".tweetcontainer1").parent().find(".generated-links").length == 0) {
			$(".tweetcontainer1 .tweet_list li").each(function () {
				linksFound = $(this).find(".tweet_text a");
				if (linksFound.length == 1) {
				} else {
					if (linksFound.length > 1) {
						newList = $('<ul class="generated-links"></ul>');
						$(this).find(".tweet_text a").each(function () {
							listItem = $("<li>");
							$(this).clone().appendTo(listItem);
							listItem.appendTo(newList)
						});
						$(this).after(newList)
					}
				}
			});
			initSameHeight();
			clearInterval(tweetLinkParser)
		}
		return;
		if (links.length > 1) {
			rawTxt = $.each(links, function (d, b) {
				link = $(this).attr("href");
				$(".twitter-box .generated-links").append('<li><a href="' + link + '">' + link + "</a></li>")
			})
		} else {
			if (links.length == 1) {
				var a = false;
				$(".twitter-post .twitter-message").click(function (b) {
					if ($(this).find("a").attr("target") == "_blank") {
						window.open($(this).find("a").attr("href"))
					} else {
						window.location.href = $(this).find("a").attr("href")
					}
				})
			}
		}
	}

	function menuFixHeight(b) {
		if (!$(".webgis").length) {
			currentHeight = $("#menu-scroller").height();
			newHeight = b.height();
			if (newHeight > currentHeight) {
				$("#menu-scroller").height(newHeight)
			}
			var a = $(".main-holder");
			if (a.height() < newHeight) {
				a.css("min-height", newHeight + "px")
			}
		}
	}

	function isRetina() {
		var a = (typeof exports == "undefined" ? window : exports);
		var b = "(-webkit-min-device-pixel-ratio: 1.5), (min--moz-device-pixel-ratio: 1.5), (-o-min-device-pixel-ratio: 3/2), (min-resolution: 1.5dppx)";
		if (a.devicePixelRatio > 1) {
			return true
		}
		if (a.matchMedia && a.matchMedia(b).matches) {
			return true
		}
		return false
	}

	String.prototype.endsWith = function (a) {
		return this.indexOf(a, this.length - a.length) !== -1
	};
	function resizemodal() {
		var b = $(".modal");
		if (b.length > 0) {
			b.css("visibility", "hidden");
			var a = b.height();
			var d = b.width();
			if ($(document).innerWidth() > MAX_WIDTH_S) {
				b.css({marginLeft: -0.5 * d, marginTop: -0.5 * a, height: "auto"})
			} else {
				b.css({marginLeft: 0, marginTop: 0, height: $(window).height()})
			}
			b.css("visibility", "visible");
			$(".overlay, .modal").fadeIn("slow");
			$("a, input, button, select, textarea").attr("tabindex", "-1");
			$(".modal a, .modal input, .modal button, .modal select, .modal textarea").attr("tabindex", "1");
			$(".overlay, .modal .cancel, .modal .close").click(function () {
				$(".overlay, .modal").fadeOut("slow", function () {
					$("#stuurdoor-container").hide();
					$("a, input, button, select, textarea").attr("tabindex", "0")
				})
			})
		}
	}

	$(window).load(function () {
		$(".calc-width").each(function () {
			var a = 0;
			$.each($(this).find($(this).attr("data-calcselector")), function () {
				a += $(this).outerWidth()
			});
			$(this).width(a)
		});
		updateTruncation();
		jcf.customForms.replaceAll()
	});
	function updateTruncation() {
		if (truncateObjs.length > 0) {
			$.each(truncateConfig, function (b, a) {
				$.fn.ThreeDots.the_selected = $(this.ait_selector);
				$(this.ait_selector).ThreeDots.update(this)
			})
		}
	}

	function showDayEvents(a) {
		$(".cal-current-month").removeClass("active");
		$(a).parent().addClass("active");
		$(".cal-events").html("");
		$.each($(a).find(".cal-day-content a"), function (d, b) {
			curObj = $(b);
			eventTxt = curObj.attr("data-originalspan");
			timeslot = curObj.attr("data-timeslot") !== undefined && curObj.attr("data-timeslot") !== false ? curObj.attr("data-timeslot") : "";
			eventLink = curObj.attr("href") !== undefined && curObj.attr("href") !== false ? curObj.attr("href") : "";
			eventHTML = eventLink != "" ? '<a href="' + eventLink + '">' : "";
			eventHTML += '<div class="cal-event"><div class="title">' + eventTxt + '</div><div class="timeslot">' + timeslot + "</div></div>";
			eventHTML += eventLink != "" ? "</a>" : "";
			newEvent = $(eventHTML);
			$(".cal-events").append(newEvent)
		})
	}

	function PostAge(b) {
		var a = (new Date()) - (new Date(b));
		diffSeconds = a / 1000;
		diffMinutes = a / 60000;
		diffHours = a / 3600000;
		diffDays = a / 86400000;
		diffWeeks = Math.floor(diffDays / 7);
		diffYears = diffDays / 365;
		if (diffMinutes < 1) {
			return Math.floor(diffSeconds) + " seconden geleden"
		}
		if (diffHours < 1) {
			return Math.floor(diffMinutes) + " minuten geleden"
		}
		if (diffDays < 1) {
			return Math.floor(diffHours) + " uur geleden"
		}
		if (diffDays < 7) {
			return Math.floor(diffDays) + " dagen geleden"
		}
		if (diffDays < 365) {
			return diffWeeks > 1 ? diffWeeks + " weken geleden" : "1 week geleden"
		} else {
			return Math.floor(diffYears) + " jaar geleden"
		}
	}

	function getParameters(l) {
		var g = {};
		var b = 0;
		var j, f = /\+/g, h = /([^&;=]+)=?([^&;]*)/g, k = function (a) {
			return decodeURIComponent(a.replace(f, " "))
		};
		while (j = h.exec(l)) {
			g[k(j[1])] = k(j[2]);
			b++
		}
		return [g, b]
	}

	function getOpenCloseText(d) {
		var b = d.attr("data-close");
		b = b != "" ? b : "Sluiten";
		var a = d.attr("data-open");
		a = a != "" ? a : "Openen";
		return [a, b]
	}

	function initOpenClose() {
		jQuery(".boxes-list > li").openClose({
			activeClass: "active-box",
			opener: ".box-opener",
			slider: ".slide",
			animSpeed: 400,
			effect: "slide",
			animEnd: function (a) {
				txts = getOpenCloseText(this.opener);
				$(this.opener).html(a ? txts[1] : txts[0])
			}
		});
		jQuery("div.open-close").openClose({
			activeClass: "active",
			opener: ".btn-slide",
			slider: ".slide",
			animSpeed: 400,
			effect: "slide",
			animEnd: function (a) {
				txts = getOpenCloseText(this.opener);
				$(this.opener).html(a ? txts[1] : txts[0])
			}
		});
		jQuery(".news.onLargeNoSlider").openClose({
			activeClass: "active",
			opener: ".box-opener",
			slider: ".slide",
			animSpeed: 400,
			effect: "slide",
			animEnd: function (a) {
				txts = getOpenCloseText(this.opener);
				$(this.opener).html(a ? txts[1] : txts[0])
			}
		});
		jQuery(".parking-list > li").openClose({
			activeClass: "active-box",
			opener: ".box-opener",
			slider: ".slide",
			animSpeed: 400,
			effect: "slide",
			animEnd: function (a) {
				txts = getOpenCloseText(this.opener);
				$(this.opener).html(a ? txts[1] : txts[0])
			}
		});
		jQuery(".info-block > li").openClose({
			activeClass: "active",
			opener: ".box-opener",
			slider: ".slide",
			animSpeed: 400,
			effect: "slide",
			animEnd: function (a) {
				txts = getOpenCloseText(this.opener);
				$(this.opener).html(a ? txts[1] : txts[0])
			}
		});
		jQuery(".result-list > li").openClose({
			activeClass: "active",
			opener: ".box-opener",
			slider: ".slide",
			animSpeed: 400,
			effect: "slide",
			animEnd: function (a) {
				opener = this.holder.find(".box-opener");
				txts = getOpenCloseText(opener);
				opener.html(a ? txts[1] : txts[0])
			}
		});
		jQuery("div.more-slide").openClose({
			activeClass: "active",
			opener: ".box-opener",
			slider: ".slide",
			animSpeed: 400,
			effect: "slide",
			animEnd: function (a) {
				txts = getOpenCloseText(this.opener);
				$(this.opener).html(a ? txts[1] : txts[0])
			}
		});
		jQuery(".more-info").openClose({
			activeClass: "active",
			opener: ".box-opener",
			slider: ".slide",
			animSpeed: 400,
			effect: "slide",
			animEnd: function (a) {
				txts = getOpenCloseText(this.opener);
				$(this.opener).html(a ? txts[1] : txts[0])
			}
		})
	}

	function initSameHeight() {
		jQuery(".boxes-list").sameHeight({elements: ".holder", flexible: true, multiLine: true});
		jQuery(".image-boxes").sameHeight({elements: ".holder", flexible: true, multiLine: true});
		jQuery(".posts .holder").sameHeight({elements: ".cover .post", flexible: true, multiLine: true})
	}

	function isIE(b, e) {
		var a = $('<div style="display:none;"/>').appendTo($("body"));
		a.html("<!--[if " + (e || "") + " IE " + (b || "") + "]><a>&nbsp;</a><![endif]-->");
		var d = a.find("a").length;
		a.remove();
		return d
	}

	$(document).ready(function () {
		var d = $(".content-holder").width();
		var e = $(".fotofree:not(.left,.right)");
		$.each(e, function () {
			var g = $(this).find("img.contentImage").width();
			if (g > d) {
				$(this).css("width", d)
			} else {
				$(this).css("width", g)
			}
		});
		var f = $.cookie("unsupportedbrowser");
		var a = "/unsupported.html";
		var b = (window.location.href.indexOf(a, window.location.href.length - a.length) !== -1);
		if (!f && !b && !Modernizr.mq("only all") && !isIE(8)) {
			$.cookie("unsupportedbrowser", "true", {expires: 7});
			window.location.href = a
		}
		if ($(".cover-search.sponsored").length) {
			if ($(".result-holder.search-element .data-holder").length) {
				$(".cover-search.sponsored").detach().prependTo(".result-holder.search-element .data-holder")
			}
		}
		if ($(".result-list").length) {
			$(".result-list li select").each(function (g) {
				$(this).parents(".title").next().find("div.text div").hide();
				$("#" + $(this).find("option:first").val()).show()
			});
			$(".result-list li select").live("change", function (g) {
				$(g.target).parents(".title").next().find("div.text div").hide();
				$(g.target).parents(".title").next().removeClass("js-slide-hidden").show();
				$("#" + $(g.target).val()).show()
			})
		}
		searchListeners()
	});
	function searchListeners() {
		$(".cover-search").on("click", "a.do-qgo-click-single", function () {
			var e = $(this).attr("data-qgo-handle-id");
			var d = $(this).attr("data-qgo-question-id");
			var g = $(this).attr("data-qgo-question-id");
			var f = $(this).attr("data-qgo-alias");
			var b = $(this).attr("data-qgo-siteRef");
			var a = $(this).attr("data-qgo-keywordsession");
			doQgoClick(e, d, g, f, b, a)
		});
		$(".cover-search").on("click", "a.do-qgo-click-multiple", function () {
			var e = $(this).attr("data-qgo-handle-id");
			var d = $(this).attr("data-qgo-question-id");
			var g = document.getElementById("questionId_" + d).value.replace("question" + d + "_answer", "");
			var f = $(this).attr("data-qgo-alias");
			var b = $(this).attr("data-qgo-siteRef");
			var a = $(this).attr("data-qgo-keywordsession");
			doQgoClick(e, d, g, f, b, a)
		});
		$(".cover-search").on("change", "select.do-qgo-change-multple", function () {
			var e = $(this).attr("data-qgo-handle-id");
			var d = $(this).attr("data-qgo-question-id");
			var g = document.getElementById("questionId_" + d).value.replace("question" + d + "_answer", "");
			var f = $(this).attr("data-qgo-alias");
			var b = $(this).attr("data-qgo-siteRef");
			var a = $(this).attr("data-qgo-keywordsession");
			doQgoClick(e, d, g, f, b, a)
		});
		$(".data-holder").on("click", "a.do-qgo-no-match", function () {
			var a = $(this).attr("data-qgo-handle-id");
			var b = $(this).attr("data-qgo-link-text");
			doQgoNoMatchClick(a, b)
		});
		$(".cover-search").on("click", "a.do-link-click", function () {
			var h = $(this).attr("data-dolink-keyword");
			var d = document.getElementById(h).value;
			var g = $(this).attr("title");
			var f = $(this).attr("href");
			var e = $(this).attr("data-dolink-alias");
			var a = $(this).attr("data-dolink-site-ref");
			var b = document.getElementsByName("qGohandleId")[0].value;
			doLinkClick(d, g, f, e, a, b)
		})
	}
})(jQuery);