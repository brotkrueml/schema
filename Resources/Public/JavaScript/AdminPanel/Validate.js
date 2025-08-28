(() => {
  class Validation {
    options = {
      jsonLdContentId: 'ext-schema-jsonld',
      tools: {
        rtt: {
          checkButtonId: 'ext-schema-check-rtt',
          actionUrl: 'https://search.google.com/test/rich-results'
        },
      },
    };

    jsonLd = null;

    constructor() {
      const jsonLdElement = document.getElementById(this.options.jsonLdContentId);
      if (!jsonLdElement) {
        return;
      }

      const jsonLdText = jsonLdElement.textContent;
      try {
        this.jsonLd = JSON.parse(jsonLdText);
      } catch (e) {
        console.warn('Schema check: JSON-LD is not valid JSON', jsonLdText);
      }
    }

    registerClickHandlerForButtons() {
      if (this.jsonLd === null) {
        return;
      }

      const rttButton = document.getElementById(this.options.tools.rtt.checkButtonId);
      rttButton && rttButton.addEventListener('click', this.invokeRichResultTest.bind(this));
    }

    invokeRichResultTest(event) {
      event.preventDefault();
      this.submitForm('rtt', this.options.tools.rtt.actionUrl, 'code_snippet');
    }

    submitForm(type, actionUrl, codeFieldName) {
      let code = JSON.stringify(this.jsonLd, null, '\t');
      code = '<script type="application/ld+json">\n' + code + '\n</script>';

      const form = document.createElement('form');
      form.setAttribute('method', 'post');
      form.setAttribute('action', actionUrl);
      form.setAttribute('target', 'sd-validate-' + Math.random().toString(36).substr(2, 6));
      form.setAttribute('rel', 'noreferrer');
      form.style = 'display:none';

      const codeField = document.createElement('textarea');
      codeField.setAttribute('name', codeFieldName);
      codeField.textContent = code;
      form.appendChild(codeField);
      document.body.appendChild(form);

      form.submit();
      form.remove();
    }
  }

  const init = () => {
    const validation = new Validation();
    validation.registerClickHandlerForButtons();
  }

  if (document.readyState === 'complete' || (document.readyState !== 'loading' && !document.documentElement.doScroll)) {
    init();
  } else {
    document.addEventListener('DOMContentLoaded', init);
  }
})();
