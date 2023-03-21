/*Timeout Init*/
$.sessionTimeout({
	keepAliveUrl: false,
	logoutUrl: 'login.html',
	redirUrl: 'signup.html',
	warnAfter: 1000,
	redirAfter: 1000000,
	countdownBar: false,
	keepAliveButton: 'Continue working',
	title: 'Session expiring',
	message: '',
	countdownMessage: 'You have been gone for a while, we will log you out in {timer} unless you continue session to stay signed in.'
});