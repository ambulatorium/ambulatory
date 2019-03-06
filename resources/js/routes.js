export default [
    {path: '/', redirect: '/inbox'},

    // Inbox.
    {
        path: '/inbox',
        name: 'inbox',
        component: require('./pages/inbox/index').default
    },
    {
        path: '/inbox/:id',
        name: 'inbox-preview',
        component: require('./pages/inbox/preview').default
    },

    // Medical form.
    {
        path: '/medical-form',
        name: 'medical-form',
        component: require('./pages/medical/index').default
    },
    {
        path: '/medical-form/new',
        name: 'medical-form-new',
        component: require('./pages/medical/edit').default
    },
    {
        path: '/medical-form/:id',
        name: 'medical-form-edit',
        component: require('./pages/medical/edit').default
    },

    // Working hours.
    {
        path: '/working-hours',
        name: 'working-hours',
        component: require('./pages/schedules/index').default
    },
    {
        path: '/working-hours/new',
        name: 'working-hours-new',
        component: require('./pages/schedules/edit').default
    },
    {
        path: '/working-hours/:id',
        name: 'working-hours-edit',
        component: require('./pages/schedules/edit').default
    },

    // Settings.
    {
        path: '/settings/:id',
        name: 'settings',
        component: require('./pages/settings/account').default
    },

    // Staff.
    {
        path: '/staff',
        name: 'staff',
        component: require('./pages/staff/index').default
    },

    // Locations.
    {
        path: '/locations',
        name: 'locations',
        component: require('./pages/locations/index').default
    },
    {
        path: '/locations/new',
        name: 'locations-new',
        component: require('./pages/locations/edit').default
    },
    {
        path: '/locations/:id',
        name: 'locations-edit',
        component: require('./pages/locations/edit').default
    },

    // Specialities.
    {
        path: '/specialities',
        name: 'specialities',
        component: require('./pages/specialities/index').default
    },
    {
        path: '/specialities/new',
        name: 'specialities-new',
        component: require('./pages/specialities/edit').default
    },
    {
        path: '/specialities/:id',
        name: 'specialities-edit',
        component: require('./pages/specialities/edit').default
    },

    // Invitations.
    {
        path: '/invitations',
        name: 'invitations',
        component: require('./pages/invitations/index').default
    },
    {
        path: '/invitations/new',
        name: 'invitations-new',
        component: require('./pages/invitations/edit').default
    },
    {
        path: '/invitations/:id',
        name: 'invitations-edit',
        component: require('./pages/invitations/edit').default
    },

    // Catch All.
    {
        path: '*',
        name: 'catch-all',
        component: require('./pages/errors/404').default,
    },
];