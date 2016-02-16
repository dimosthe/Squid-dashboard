
/* Enables links when are active*/
$('a[href="' + this.location.pathname + '"]').parent().addClass('active');
$('a[href="' + this.location.pathname + '"]').parent().parent().parent().addClass('active');

if(this.location.pathname.indexOf("/user/") != -1 && this.location.pathname.indexOf("/user/create") == -1){
	$('a[href="/users"]').parent().addClass('active');
	$('a[href="/users"]').parent().parent().parent().addClass('active');
}

if(this.location.pathname.indexOf("/webaccessgroup/") != -1 && this.location.pathname.indexOf("/webaccessgroup/create") == -1){
	$('a[href="/webaccessgroups"]').parent().addClass('active');
	$('a[href="/webaccessgroups"]').parent().parent().parent().addClass('active');
}

if(this.location.pathname.indexOf("/filteringgroup") != -1 && this.location.pathname.indexOf("/filteringgroup/create") == -1){
	$('a[href="/filteringgroups"]').parent().addClass('active');
	$('a[href="/filteringgroups"]').parent().parent().parent().addClass('active');
}

if(this.location.pathname.indexOf("/blacklist") != -1){
	$('a[href="/blacklists"]').parent().addClass('active');
	$('a[href="/blacklists"]').parent().parent().parent().addClass('active');
}