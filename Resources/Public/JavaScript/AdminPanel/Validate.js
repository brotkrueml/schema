(() => {
  class Validation {
    options = {
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

      const sdttButton = document.getElementById(this.options.tools.sdtt.checkButtonId);
      sdttButton && sdttButton.addEventListener('click', this.invokeStructuredDataTestingTool.bind(this));
    }

    invokeRichResultTest(event) {
      event.preventDefault();
      this.submitForm(this.options.tools.rtt.actionUrl, 'code_snippet');
    }

    invokeStructuredDataTestingTool(event) {
      event.preventDefault();
      this.submitForm(this.options.tools.sdtt.actionUrl, 'code');
    }

    submitForm(actionUrl, codeFieldName) {
      const form = document.createElement('form');
      form.setAttribute('method', 'post');
      form.setAttribute('action', actionUrl);
      form.setAttribute('target', 'sd-validate-' + Math.random().toString(36).substr(2, 6));
      form.setAttribute('rel', 'noopener');
      form.style = 'display:none';

      const codeField = document.createElement('textarea');
      codeField.setAttribute('name', codeFieldName);
      codeField.textContent = JSON.stringify(this.jsonLd, null, '\t');
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
