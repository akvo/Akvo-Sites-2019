<div id="akvo-support-link" class="">
	<a target="_blank" href="http://sitessupport.akvo.org/form">Help</a>
</div>
<style>
	#akvo-support-link{
		font-size: 16px;
		background-color: #009900;
		color: #fff;
		position: fixed;
		right: -10px;
		padding: 8px 10px 10px;
		z-index:230;
		transform: rotate(270deg);
		top: 200px;
		border-top-left-radius: 5px;
		border-top-right-radius: 5px;
	}
	#akvo-support-link a[href]{
		color: inherit;
		text-decoration: none;
	}
	
	
	.datafeed-admin-option-feeds{
		display: grid;
		grid-template-columns: 1fr 1fr;
		grid-gap: 20px;
		margin-top: 20px;
	}
	@media( max-width:768px ){
		.datafeed-admin-option-feeds{
			grid-template-columns: 1fr;
		}	
	}
	
	.datafeed-info{
		padding: 20px;
		background-color: #fff;
	}
	
	.datafeed-info dl:first-child{ 
		border-bottom: #ddd solid 1px; 
		margin: 0 -20px 10px;
		padding: 0 20px;
	}
	.datafeed-info dl:first-child a[href], #datafeed-admin-options-add-link{
		border: #ddd solid 1px;
		padding: 5px 10px;
		font-size: 14px;
		text-decoration: none;
		background: #fff;
	} 
	.datafeed-info dl:first-child a[href]:hover, #datafeed-admin-options-add-link:hover{ text-decoration: underline; }
	.datafeed-info dl:first-child dt{ display:none; }
	
	
	.ui-widget-overlay{
		height: 100%;
		position: fixed;
	}
	#datafeed-add-feed-dialog-form div{
		margin: 10px 0;
	}
	
	.ui-dialog .ui-dialog-titlebar-close span, .ui-dialog .ui-dialog-titlebar-close span{
		display: none;
	}
	.ui-dialog .ui-dialog-titlebar-close{
		border: none;
		background: none;
	}
	.ui-dialog-titlebar-close:before{
		line-height: 15px;
	}
</style>