import LeadController from './LeadController'
import HomeContentController from './HomeContentController'
import FeedbackController from './FeedbackController'
const Admin = {
    LeadController: Object.assign(LeadController, LeadController),
HomeContentController: Object.assign(HomeContentController, HomeContentController),
FeedbackController: Object.assign(FeedbackController, FeedbackController),
}

export default Admin