document.body.innerHTML = `
  <dialog data-pokemon-modal>
    <h2></h2>
    <img src="" alt="">
    <p data-category></p>
    <ul data-list-types></ul>
    <ul data-list-sensibilities></ul>
    <ol data-list-evolutions></ol>
    <div data-extra-evolutions hidden></div>
    <div data-sex="male"></div>
    <div data-sex="asexual" hidden></div>
    <div data-sex="female"></div>
    <span data-sex-rate="male"></span>
    <span data-sex-rate="female"></span>
    <span data-sex-label="female"></span>
    <span data-sex-label="male"></span>
    <span data-weight></span>
    <span data-height></span>
    <ul data-list-abilities></ul>
    <ul data-list-games></ul>
    <span data-nb-games></span>
    <span data-nb-regional-forms></span>
    <ul data-list-regional-forms></ul>
    <span data-nb-forms></span>
    <ul data-list-forms></ul>
    <div data-sprites-container></div>
    <div data-top-infos></div>
    <ul data-list-siblings-pokemon></ul>
    <dl data-statistics></dl>
    <span data-catch-rate></span>
    <div data-pkmn-acronym-versions></div>
    <p data-no-evolutions></p>
    <button data-toggle-picture-in-picture></button>
  </dialog>
`;