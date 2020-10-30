export function getStateString(state) {
    switch (state) {
        case 'draft': {
            return 'Draft';
        }
        case 'submitted': {
            return 'Submitted';
        }
        case 'approved': {
            return 'Approved';
        }
        case 'published': {
            return 'Published';
        }
        case 'rejected': {
            return 'Rejected'
        }
        default: {
            return '';
        }
    }
}