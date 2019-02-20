<!DOCTYPE HTML>

<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>uCup</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="important/css/main.css" />

    <script language="JavaScript">

        window.inputTypeNumberPolyfill = {

            clipboardIsNumeric: function (event) {
                event = (event) ? event : window.event;
                var clipboardData = (event.clipboardData) ? event.clipboardData.getData('Text') : window.clipboardData.getData('Text');
                var isNumber = /^\d+$/.test(clipboardData);
                return (isNumber);
            },

            eventIsBlockedByMaxWhenPasting: function (event, element) {
                var maximumValueLength = this.getMaxValueLength(element);
                if (maximumValueLength) {
                    event = (event) ? event : window.event;
                    var clipboardData = (event.clipboardData) ? event.clipboardData.getData('Text') : window.clipboardData.getData('Text');
                    var clipboardDataLength = (typeof clipboardData === 'undefined') ? 0 : clipboardData.length;
                    var selectedTextLength = this.getSelectedTextLength(event, element);
                    return ((element.value.length + clipboardDataLength - selectedTextLength) > maximumValueLength);
                }
                return false;
            },

            getSelectedTextLength: function (event, element) {
                var selectionLength = 0;

                try {
                    // Used by Firefox and modern IE (using a Chrome workaround).
                    selectionLength = (element.selectionEnd - element.selectionStart);
                    selectionLength = (typeof selectionLength === 'number' && !isNaN(selectionLength)) ? selectionLength : 0;
                } catch (error) {
                }

                if (!selectionLength) {
                    if (window.getSelection) {
                        // Used by Chrome.
                        var selection = window.getSelection();
                        selectionLength = (selection === 'undefined') ? 0 : selection.toString().length;
                    } else if (document.selection && document.selection.type !== 'None') {
                        // Used IE8.
                        var textRange = document.selection.createRange();
                        selectionLength = textRange.text.length;
                    }
                }

                return selectionLength;
            },

            eventIsBlockedByMaxWhenTyping: function (event, element) {
                var maximumValueLength = this.getMaxValueLength(element);
                if (maximumValueLength) {
                    event = (event) ? event : window.event;
                    var selectedTextLength = this.getSelectedTextLength(event, element);
                    var characterLength = this.getCharCodeLength(event);
                    return ((element.value.length - selectedTextLength + characterLength) > maximumValueLength);
                }
                return false;
            },

            getMaxValueLength: function (element) {
                var maximumValue = element.getAttribute('max');
                if (!maximumValue || !/^\d+$/.test(maximumValue)) {
                    return 0;
                } else {
                    return maximumValue.length;
                }
            },

            eventKeyIsDigit: function (event) {
                event = (event) ? event : window.event;
                var keyCode = (event.which) ? event.which : event.keyCode;
                return (this.codeIsADigit(keyCode) || this.charCodeIsAllowed(event));
            },

            codeIsADigit: function (code) {
                var stringCode = String.fromCharCode(code);
                return /^\d$/.test(stringCode);
            },

            charCodeIsAllowed: function (event) {
                event = (event) ? event : window.event;
                var charCode = event.charCode;
                var keyCode = (event.which) ? event.which : event.keyCode;
                charCode = (typeof charCode === 'undefined') ? keyCode : charCode; // IE8 fallback.

                if (charCode === 0) {
                    // Non typeable characters are allowed.
                    return true;
                } else if (event.altKey || event.ctrlKey || event.shiftKey || event.metaKey) {
                    // All combinations are allowed.
                    return true
                } else if (!this.codeIsADigit(charCode)) {
                    // Any other character that is not a digit will be blocked.
                    return false;
                }

                // The only characters left are numeric, so we let them through.
                return true;
            },

            getCharCodeLength: function (event) {
                event = (event) ? event : window.event;
                var charCode = event.charCode;
                var keyCode = (event.which) ? event.which : event.keyCode;
                charCode = (typeof charCode === 'undefined') ? keyCode : charCode; // IE8 fallback.

                if (charCode === 0) {
                    // Non typeable characters have no length.
                    return 0;
                } else if (event.altKey || event.ctrlKey || event.shiftKey || event.metaKey) {
                    // All combinations have no length.
                    return 0
                } else if (!this.codeIsADigit(charCode)) {
                    // All non-allowed characters have 0 length (because they will be blocked).
                    return 0;
                }

                return 1; // By default a character has a length of 1.
            },

            polyfillElement: function (element) {

                element.addEventListener('keypress', function (event) {
                    if (!inputTypeNumberPolyfill.eventKeyIsDigit(event) ||
                        inputTypeNumberPolyfill.eventIsBlockedByMaxWhenTyping(event, element)) {
                        event.preventDefault();
                    }
                });

                element.addEventListener('paste', function (event) {
                    if (!inputTypeNumberPolyfill.clipboardIsNumeric(event) ||
                        inputTypeNumberPolyfill.eventIsBlockedByMaxWhenPasting(event, element)) {
                        event.preventDefault();
                    }
                });

            }
        };

    </script>

</head>
<body>

<!-- Header -->
<header id="header" class="alt">
    <span style="color: #258cd1">uCup</span> <span>by CuatroInteligentes</span>
    <div class="logo">  &#8195; &#8195; <a href="index.html">Home</a> &#8195; &#8195;
        <a href="#use">Set up your cup</a> &#8195; &#8195;
        <a href="#about">About our project</a> &#8195; &#8195;
        <a href="#team">Team</a></div> &#8195; &#8195;
</header>

<!-- Nav -->
<nav id="menu">
    <ul class="links">
        <li><a href="index.html">Home</a></li>
        <li><a href="#use">Set up your cup</a></li>
        <li><a href="#about">About our project</a></li>
        <li><a href="#team">Team</a></li>
    </ul>
</nav>

<!-- Banner -->
<section id="banner">
    <div class="inner">
        <header>
            <h1>This is uCup</h1>
            <p>In a world, where everyone tries to solve the global</br>
                problems of mankind, we improve the things of your everyday life.</p>
        </header>
        <a href="#about" class="button big scrolly">Learn More</a>
    </div>
</section>

<!-- Main -->
<div id="main">

    <!-- Section -->
    <section id="use" class="wrapper style1">
        <div class="inner">
            <!-- 2 Columns -->
            <div class="flex flex-2">
                <div class="col col1">
                    <div class="image round fit">
                        <a href="generic.html" class="link"><img src="images/pic01.jpg" alt="" /></a>
                    </div>
                </div>
                <div  class="col col2">
                    <h3>Use your cup</h3>
                    <p>We are trying to make your life a little bit easier. <br>
                    <ul> Here are some hints about temperature:
                        <li><span style="color: #d08224">60 degrees - hotter</span></li>
                        <li><span style="color: #d08224">50 degrees - medium</span></li>
                        <li><span style="color: #d08224">40 degrees - colder</span></li>
                    </ul>
                    </p>
                    <!-- Here is going to be intro video -->
                    <p> Now set up your cup</p>
                    <form action="buf_function.php" method="post">
                        <label>Input comfortable temperature</label>
                        <div class="group">
                            <input type="number" style="height:2.85em; width:5em; padding-left:1.5em; margin-right:2em; border-radius:0.01em" name="temp" value="" id="number" min="10" max="99">
                            <span class="bar"></span>
                            <input class="button" type="submit" name="temp_submit" value="Send">
                        </div>
                    </form>

                    <script>
                        let number = document.getElementById("number");
                        inputTypeNumberPolyfill.polyfillElement(number);
                    </script>

                </div>
            </div>
        </div>
    </section>

    <!-- Section -->
    <section id="about"  class="wrapper style2">
        <div class="inner">
            <div class="flex flex-2">
                <div class="col col2">
                    <h3>About our idea</h3>
                    <p>We invite you to take advantage of our little invention that solves, albeit small, <br> but such annoying problems of our everyday life.
                        Has it ever happened to you that you made <br> yourself tea or coffee and, while waiting for the drink to cool down, started to do your own business,
                        and when you return the coffee was cold?<br> We give you a solution of this problem.
                        Just choose a comfortable temperature for you and we will send you a notification when the drink is comfortable for your consumption. <br> </p>
                    <a href="#use" class="button big scrolly">Use your cup</a>
                </div>
                <div class="col col1 first">
                    <div class="image round fit">
                        <img src="images/pic02.jpg" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section -->
    <section id="team" class="wrapper style1">
        <div class="inner">
            <header class="align-center">
                <h2>Our team</h2>
                <p>Meet everyone who worked on the cup</p>
            </header>
            <div class="flex flex-3">
                <div class="col align-center">
                    <div class="image round fit">
                        <img src="images/pic03.jpg" alt="" />
                    </div>
                    <p><b>Olexandr Petrovskyi</b> <br> Team leader
                        <br> Engineer
                        <br> Back-end developer

                    </p>

                </div>
                <div class="col align-center">
                    <div class="image round fit">
                        <img src="images/pic05.jpg" alt="" />
                    </div>
                    <p> <b>Khrystyna Kruchkovska</b> <br> Front-end developer</p>

                </div>
                <div class="col align-center">
                    <div class="image round fit">
                        <img src="images/pic04.jpg" alt="" />
                    </div>
                    <p><b>Kirill Petrov</b><br> Back-end developer</p>

                </div>

                <div class="col align-center">
                    <div class="image round fit">
                        <img src="images/pic06.jpg" alt="" />
                    </div>
                    <p><b>Anastasiia Zhuk</b> <br> Video-advertising  </p>

                </div>
            </div>
        </div>
    </section>

</div>

<!-- Footer -->
<footer id="footer">
    <div class="copyright">
        <p> Adress: Kniazia Romana Street<br>
            Phone number: +380 (32) 582 404<br>
            E-mail: ai.dept@lpnu.ua<br>
            With love by CuatroInteligentes</p>
    </div>
</footer>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.scrolly.min.js"></script>
<script src="assets/js/jquery.scrollex.min.js"></script>
<script src="assets/js/skel.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>