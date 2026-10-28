import LeadController from './LeadController'
import HomeContentController from './HomeContentController'
const Admin = {
    LeadController: Object.assign(LeadController, LeadController),
HomeContentController: Object.assign(HomeContentController, HomeContentController),
}

export default Admin