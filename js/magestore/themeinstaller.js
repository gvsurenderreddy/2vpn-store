
var ThemeInstaller = Class.create();
ThemeInstaller.prototype = {
    initialize: function(container, form, markId, installUrl, backUrl, finishUrl, cancelUrl){
        this.container = container;
        this.form = form;     
        this.markId = markId;     
        this.installUrl = installUrl;     
        this.backUrl = backUrl;     
        this.finishUrl = finishUrl;     
        this.cancelUrl = cancelUrl;     
    },
	
	run : function()
	{	
		var url = this.installUrl;
		var parameters = $(this.form).serialize(true);
		
		var wizardInstallerForm = new varienForm(this.form);
		
		if(!wizardInstallerForm.validate()){
            return;
        }
		
		this.mark();
		
		new Ajax.Updater(this.container, url, {
			  method: 'post',	
			  parameters: parameters,
		      onSuccess: this.onSuccess,
			  onFailure: this.onFailure,
			  onComplete: this.onComplete			  
		  });	
	},
	
	back : function()
	{	
		var url = this.backUrl;
		var parameters = $(this.form).serialize(true);
		
		var wizardInstallerForm = new varienForm(this.form);
		
		this.mark();
		
		new Ajax.Updater(this.container, url, {
			  method: 'post',	
			  parameters: parameters,
		      onSuccess: this.onSuccess,
			  onFailure: this.onFailure,
			  onComplete: this.onComplete
		  });	
	},	

	finish : function()
	{	
		var url = this.finishUrl;
		var parameters = $(this.form).serialize(true);
		
		var wizardInstallerForm = new varienForm(this.form);
		
		this.mark();
		
		new Ajax.Request(url, {
			  method: 'post',	
			  parameters: parameters,
		      onSuccess: this.onSuccess,
			  onFailure: this.onFailure,
			  onComplete: function(){closeWizardInstaller();}
		  });	
	},		
	
	cancel : function()
	{	
		var url = this.cancelUrl;
		var parameters = $(this.form).serialize(true);
		
		var wizardInstallerForm = new varienForm(this.form);
		
		this.mark();
		
		new Ajax.Request(url, {
			  method: 'post',	
			  parameters: parameters,
		      onSuccess: this.onSuccess,
			  onFailure: this.onFailure,
			  onComplete: function(){closeWizardInstaller();}
		  });	
	},		
	
	onFailure: function(transport)
	{

    },
	
	onComplete: function(transport)
	{
		$('themeinstaller-waiting').hide();
		$('wizard-installer-content').style.background = "none";
		$('wizard-installer-content').style.opacity = "1";
	},
	
	onSuccess: function(transport)
	{
		if (transport && transport.responseText) {
            try{
                response = eval('(' + transport.responseText + ')');
            }
            catch (e) {
                response = {};
            }
			
			if (response) {

            }else{
			}			
		}	
	},
	
	showHomepageConfig: function(elementID,checkBoxID)
	{
		$(elementID).show();
		$(checkBoxID).checked = true;
	},
	
	hideHomepageConfig: function(elementID,checkBoxID)
	{
		$(elementID).hide();
		$(checkBoxID).checked = false;
	},
		
	mark: function()
	{
		$('wizard-installer-content').style.background = "#efefef";
		$('wizard-installer-content').style.opacity = "0.4";
		$(this.markId).show();
	},
	
	unmark: function()
	{
		$('wizard-installer-content').style.background = "#ffffff";
		$('wizard-installer-content').style.opacity = "0";
		$('themeinstaller-waiting').hide();
	}
		
}