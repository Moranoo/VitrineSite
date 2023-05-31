const quotes = async () => {
    // API : https:/apidapi.com/martin.svoboda/api/quotes15/
    //url contient le ssite ou l’API se trouve 
     let url = 'https://quotes15.p.rapidapi.com/quotes/random/?language_code=fr';
    let options = {
     method: 'GET', 
     headers: {
        'X-RapidAPI-Key':'31c5b37b10msh3838b234811cf59p1265aajsn7b6dcdda16d7'} };
     let res = await fetch(url, options); 
     if(res.ok){
      let json = await res.json();
     console.log(json)
      document.querySelector('h1').innerHTML = json.content;
      }else{
     console.error('Une erreur est survenue');
    }}
     
    quotes();
