(() => {
  class Copy {
    options = {
      jsonLdContentId: 'ext-schema-jsonld',
      copyButtonId: 'ext-schema-copy',
      clipboardIconId: 'ext-schema-copy-clipboard',
      checkIconId: 'ext-schema-copy-check',
    };

    jsonLdText = null;

    registerClickHandlerForButton() {
      if (this.jsonLdText === null) {
        const jsonLdElement = document.getElementById(this.options.jsonLdContentId);
        if (!jsonLdElement) {
          return;
        }

        try {
          this.jsonLdText = JSON.stringify(JSON.parse(jsonLdElement.textContent), null, 2);
        } catch (error) {
          console.error(error.message);
        }
      }

      const copyButton = document.getElementById(this.options.copyButtonId);
      copyButton && copyButton.addEventListener('click', this.writeToClipboard.bind(this));
    }

    async writeToClipboard(event) {
      event.preventDefault();
      try {
        await navigator.clipboard.writeText(this.jsonLdText);

        document.getElementById(this.options.checkIconId)?.removeAttribute('hidden');
        document.getElementById(this.options.clipboardIconId)?.setAttribute('hidden', 'hidden');

        window.setTimeout(() => {
          document.getElementById(this.options.checkIconId)?.setAttribute('hidden', 'hidden');
          document.getElementById(this.options.clipboardIconId)?.removeAttribute('hidden');
        }, 5000);
      } catch (error) {
        console.error(error.message);
      }
    }
  }

  const init = () => {
    const copy = new Copy();
    copy.registerClickHandlerForButton();
  }

  if (document.readyState === 'complete' || (document.readyState !== 'loading' && !document.documentElement.doScroll)) {
    init();
  } else {
    document.addEventListener('DOMContentLoaded', init);
  }
})();
