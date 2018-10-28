<html>

<head>

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

<form action="buf_function.php" method="post">

    <input type="number" name="temp" value="" id="number" min="10" max="99">

    <input type="submit" name="temp_submit"
           value="Set the temperature"/>

</form>

<script>
     let number = document.getElementById("number");
     inputTypeNumberPolyfill.polyfillElement(number);
</script>

</body>
</html>