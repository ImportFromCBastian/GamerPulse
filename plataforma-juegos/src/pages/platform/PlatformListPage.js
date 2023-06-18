import React, { useState, useEffect } from 'react';
import Header from '../../components/HeaderComponent';
import NavBar from '../../components/NavBarComponent';
import Footer from '../../components/FooterComponent';
import { Link } from 'react-router-dom';
import axios from 'axios';
import endpoints from '../../config/endpoints';
import PlatformRow from './PlatformRow';

import { IoIosCreate } from 'react-icons/io';

const PlatformListPage = () => {

  const [platforms, setPlatforms] = useState(null);

  useEffect(() => {
    fetchPlatformData();
  }, []);

  const fetchPlatformData = async () => {
    try {
      const response = await axios
        .get(`${endpoints.platform.get}`);
      setPlatforms(response.data);

    } catch (error) {
      console.error(error);

    }
  }


  if (!platforms) return null;

  return (
    <>
      <Header />
      <NavBar />
      <Link to="/platforms/new_platform">
        <button> <IoIosCreate /> </button>
      </Link>
      <div className="List">
        {platforms.map(({ id, nombre }, index) =>
          <PlatformRow key={id} elem={{ id,nombre, index }} />
        )}
      </div>
      <Footer />
    </>
  )
}

export default PlatformListPage;