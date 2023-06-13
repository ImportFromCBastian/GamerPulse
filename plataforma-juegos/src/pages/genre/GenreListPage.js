import React from 'react';
import axios from 'axios';
import {useEffect} from 'react';
import endpoint from 
  
/* 
  export const endopoint = {
    genre:{
      get:``""''
    },
  }


*/

const GenreListPage = () =>{

  useEffect(()=>{

  },["smooth"]);

  const fetchUserData = async () => {
    try {
      const response = await
        axios.get(`${endpoint.genre.get}`);
      axios.get(`http://localhost:8000/GamerPulse/genders`);
      axios.get(`http://localhost:8000/GamerPulse/genders/`);
      console.log(response);
    } catch (error) {
      console.error(error);

    }
  }

  return(

    <div>
      <hr/>
      <div></div>
    </div>
  )
}

export default GenreListPage;