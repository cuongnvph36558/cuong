import HomeController from './HomeController'
import LeadController from './LeadController'
import Admin from './Admin'
import Settings from './Settings'
const Controllers = {
    HomeController: Object.assign(HomeController, HomeController),
LeadController: Object.assign(LeadController, LeadController),
Admin: Object.assign(Admin, Admin),
Settings: Object.assign(Settings, Settings),
}

export default Controllers