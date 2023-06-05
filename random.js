
const getQuote = async () => {
  let url = 'https://quotes15.p.rapidapi.com/quotes/random/?language_code=fr';
  let options = {
    method: 'GET',
    headers: {
      'X-RapidAPI-Key':
    }
  };

  let res = await fetch(url, options);
  if (res.ok) {
    let json = await res.json();
    console.log(json);

    displayQuote(json); // Afficher la citation
  } else {
    console.error('Une erreur est survenue');
  }
};

const displayQuote = (quote) => {
  const quoteContentElement = document.getElementById('quote-content');
  quoteContentElement.textContent = quote.content;
};

window.addEventListener('DOMContentLoaded', () => {
  getQuote();
});
