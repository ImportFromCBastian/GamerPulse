import './assets/App.css';
import './assets/index.css';
import {BrowserRouter,Route,Routes} from "react-router-dom";
//Page Components

import DashboardPage from './pages/dashboard/DashboardPage';
import GenreListPage from './pages/genre/GenreListPage';
import PlatformListPage from './pages/platform/PlatformListPage';

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path={'/'} element={<DashboardPage/>} />
        <Route path={'/generos'} element={<GenreListPage/>} />

      </Routes>

    </BrowserRouter>
  );
}

export default App;
