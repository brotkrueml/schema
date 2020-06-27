(function() {
  "use strict";

  var selectors = {
    checkButtonId: 'ext-schema-check-sdtt',
    jsonLdContentId: 'ext-schema-jsonld',
  };

  var registerClickHandlerForValidateButton = function() {
    var checkButton = document.getElementById(selectors.checkButtonId);
    checkButton && checkButton.addEventListener('click', invokeStructuredDataTestingTool);
  }

  var invokeStructuredDataTestingTool = function(event) {
    event.preventDefault();

    var jsonLdElement = document.getElementById(selectors.jsonLdContentId);
    if (!jsonLdElement) {
      return;
    }

    var jsonLdText = jsonLdElement.textContent;
    try {
        var jsonLdObject = JSON.parse(jsonLdText);
    } catch (e) {
        console.warn('Schema check: JSON-LD is not valid JSON', jsonLdText);
        return;
    }

    var form = document.createElement('form');
    form.setAttribute('method', 'post');
    form.setAttribute('action', 'https://search.google.com/structured-data/testing-tool');
    form.setAttribute('target', 'sdtt-' + Math.random().toString(36).substr(2, 6));
    form.setAttribute('rel', 'noreferrer');
    form.style = 'display:none';

    var codeField = document.createElement('textarea');
    codeField.setAttribute('name', 'code');
    codeField.textContent = JSON.stringify(jsonLdObject, null, '\t');
    form.appendChild(codeField);
    document.body.appendChild(form);

    form.submit();
    form.remove();
  }

  if (document.readyState === "complete" || (document.readyState !== "loading" && !document.documentElement.doScroll)) {
    registerClickHandlerForValidateButton();
  } else {
    document.addEventListener("DOMContentLoaded", registerClickHandlerForValidateButton);
  }
})();
