export default [
    {path: '/', redirect: '/inbox'},

    // Inbox.
    {
        path: '/inbox',
        name: 'inbox',
        component: require('./views/inbox/index').default
    },
    {
        path: '/inbox/:id',
        name: 'inbox-preview',
        component: require('./views/inbox/preview').default
    },

    // Schedules.
    {
        path: '/schedules',
        name: 'schedules',
        component: require('./views/schedules/index').default
    },
    {
        path: '/schedules/new',
        name: 'schedules-new',
        component: require('./views/schedules/edit').default
    },
    {
        path: '/schedules/:id',
        name: 'schedules-edit',
        component: require('./views/schedules/edit').default
    },

    // Medical form.
    {
        path: '/medical-forms',
        name: 'medical-forms',
        component: require('./views/medical/index').default
    },
    {
        path: '/medical-forms/new',
        name: 'medical-forms-new',
        component: require('./views/medical/edit').default
    },
    {
        path: '/medical-forms/:id',
        name: 'medical-forms-edit',
        component: require('./views/medical/edit').default
    },

    // Staff.
    {
        path: '/staff',
        name: 'staff',
        component: require('./views/staff/index').default
    },

    // Invitations.
    {
        path: '/invitations',
        name: 'invitations',
        component: require('./views/invitations/index').default
    },
    {
        path: '/invitations/new',
        name: 'invitations-new',
        component: require('./views/invitations/edit').default
    },
    {
        path: '/invitations/:id',
        name: 'invitations-edit',
        component: require('./views/invitations/edit').default
    },

    // Specializations.
    {
        path: '/specializations',
        name: 'specializations',
        component: require('./views/specializations/index').default
    },
    {
        path: '/specializations/new',
        name: 'specializations-new',
        component: require('./views/specializations/edit').default
    },
    {
        path: '/specializations/:id',
        name: 'specializations-edit',
        component: require('./views/specializations/edit').default
    },

    // Health facilities.
    {
        path: '/health-facilities',
        name: 'health-facilities',
        component: require('./views/facilities/index').default
    },
    {
        path: '/health-facilities/new',
        name: 'health-facilities-new',
        component: require('./views/facilities/edit').default
    },
    {
        path: '/health-facilities/:id',
        name: 'health-facilities-edit',
        component: require('./views/facilities/edit').default
    },

    // Settings.
    {
        path: '/settings/account',
        name: 'settings-account',
        component: require('./views/accounts/edit').default
    },
    {
        path: '/settings/password/new',
        name: 'new-password',
        component: require('./views/password/new').default
    },
    {
        path: '/settings/doctor-profile',
        name: 'settings-doctor-profile',
        component: require('./views/doctors/edit').default
    },

    // Catch All.
    {
        path: '*',
        name: 'catch-all',
        component: require('./views/errors/404').default,
    },
];