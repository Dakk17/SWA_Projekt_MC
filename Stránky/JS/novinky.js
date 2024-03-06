
// Přidání dalších novinek do kontejneru
const newsContainer = document.getElementById('newsContainer');

// Příklad - dynamicky přidáváme další novinku
const newNewsItem = document.createElement('div');
newNewsItem.className = 'newsItem';
newsContainer.appendChild(newNewsItem);
