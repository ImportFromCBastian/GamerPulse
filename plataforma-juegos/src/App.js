import './assets/css/generalStyles.css';

import {BrowserRouter,Route,Routes} from "react-router-dom";
//Page Components

import DashboardPage from './pages/dashboard/DashboardPage';

import GenderListPage from './pages/gender/GenderListPage';
import NewGender from './pages/gender/NewGender';
import GenderDelete from './pages/gender/GenderDelete';
import EditGender from './pages/gender/EditGender';

import PlatformListPage from './pages/platform/PlatformListPage';
import PlatformDelete from './pages/platform/PlatformDelete';
import EditPlatform from './pages/platform/EditPlatform';
import NewPlatform from './pages/platform/NewPlatform';


function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path={'/'} element={<DashboardPage/>} />
        <Route path={'/genders'} element={<GenderListPage/>} />
        <Route path={'/genders/new_gender'} element={<NewGender/>} />
        <Route path={'/genders/edit_gender/:id'} element={<EditGender/>} />
        <Route path={'/genders/delete_gender/:id'} element={<GenderDelete/>} />
        <Route path={'/platforms'} element={<PlatformListPage/>} />
        <Route path={'/platforms/new_platform'} element={<NewPlatform/>} />
        <Route path={'/platforms/edit_platform/:id'} element={<EditPlatform/>} />
        <Route path={'/platforms/delete_platform/:id'} element={<PlatformDelete/>} />


      </Routes>

    </BrowserRouter>
  );
}

export default App;
