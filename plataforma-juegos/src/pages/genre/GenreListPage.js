import React from 'react';
import axios from 'axios';

import endpoints from '../../config/endpoints';

const GenreListPage = () =>{


  const fetchUserData = async () => {
    try {
      const response = await
      axios.get(`${endpoints.genre.get}`);
      console.log(response.data[0]);
    } catch (error) {
      console.error(error);

    }
  }
  return(

    <div>
      <hr/>
      <div>:0</div>
    </div>
  ) 
}

export default GenreListPage;