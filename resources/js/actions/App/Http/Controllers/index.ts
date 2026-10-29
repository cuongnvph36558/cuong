import HomeController from './HomeController'
import RecentRegistrationController from './RecentRegistrationController'
import LeadController from './LeadController'
import Admin from './Admin'
import Settings from './Settings'
const Controllers = {
    HomeController: Object.assign(HomeController, HomeController),
RecentRegistrationController: Object.assign(RecentRegistrationController, RecentRegistrationController),
LeadController: Object.assign(LeadController, LeadController),
Admin: Object.assign(Admin, Admin),
Settings: Object.assign(Settings, Settings),
}

export default Controllers