(function() {
  "use strict";

  var options = {
    jsonLdContentId: 'ext-schema-jsonld',
    tools: {
      rtt: {
        checkButtonId: 'ext-schema-check-rtt',
        actionUrl: 'https://search.google.com/test/rich-results'
      },
      smv: {
        checkButtonId: 'ext-schema-check-smv',
        actionUrl: 'https://validator.schema.org/'
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

    var smvButton = document.getElementById(options.tools.smv.checkButtonId);
    smvButton && smvButton.addEventListener('click', invokeSchemaMarkupValidator);
  }

  var invokeRichResultTest = function(event) {
    event.preventDefault();
    submitForm('rtt', options.tools.rtt.actionUrl, 'code_snippet');
  }

  var invokeSchemaMarkupValidator = function(event) {
    event.preventDefault();
    submitForm('smv', options.tools.smv.actionUrl, 'code');
  }

  var submitForm = function(type, actionUrl, codeFieldName) {
    var code = JSON.stringify(jsonLdObject, null, '\t');
    if (type === 'rtt') {
      code = '<script type="application/ld+json">\n' + code + '\n</script>';
    }

    var form = document.createElement('form');
    form.setAttribute('method', 'post');
    form.setAttribute('action', actionUrl);
    form.setAttribute('target', 'sd-validate-' + Math.random().toString(36).substr(2, 6));
    form.setAttribute('rel', 'noreferrer');
    form.style = 'display:none';

    var codeField = document.createElement('textarea');
    codeField.setAttribute('name', codeFieldName);
    codeField.textContent = code;
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
