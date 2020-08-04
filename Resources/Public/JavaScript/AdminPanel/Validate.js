(function() {
  "use strict";

  var options = {
    jsonLdContentId: 'ext-schema-jsonld',
    tools: {
      rtt: {
        checkButtonId: 'ext-schema-check-rtt',
        actionUrl: 'https://search.google.com/test/rich-results'
      },
      sdtt: {
        checkButtonId: 'ext-schema-check-sdtt',
        actionUrl: 'https://search.google.com/structured-data/testing-tool'
      }
    },
  };

  var jsonLdElement = document.getElementById(options.jsonLdContentId);
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

  var registerClickHandlerForButtons = function() {
    var rttButton = document.getElementById(options.tools.rtt.checkButtonId);
    rttButton && rttButton.addEventListener('click', invokeRichResultTest);

    var sdttButton = document.getElementById(options.tools.sdtt.checkButtonId);
    sdttButton && sdttButton.addEventListener('click', invokeStructuredDataTestingTool);
  }

  var invokeRichResultTest = function(event) {
    event.preventDefault();
    submitForm(options.tools.rtt.actionUrl, 'code_snippet');
  }

  var invokeStructuredDataTestingTool = function(event) {
    event.preventDefault();
    submitForm(options.tools.sdtt.actionUrl, 'code');
  }

  var submitForm = function(actionUrl, codeFieldName) {
    var form = document.createElement('form');
    form.setAttribute('method', 'post');
    form.setAttribute('action', actionUrl);
    form.setAttribute('target', 'sd-validate-' + Math.random().toString(36).substr(2, 6));
    form.setAttribute('rel', 'noreferrer');
    form.style = 'display:none';

    var codeField = document.createElement('textarea');
    codeField.setAttribute('name', codeFieldName);
    codeField.textContent = JSON.stringify(jsonLdObject, null, '\t');
    form.appendChild(codeField);
    document.body.appendChild(form);

    form.submit();
    form.remove();
  }

  if (document.readyState === "complete" || (document.readyState !== "loading" && !document.documentElement.doScroll)) {
    registerClickHandlerForButtons();
  } else {
    document.addEventListener("DOMContentLoaded", registerClickHandlerForButtons);
  }
})();
