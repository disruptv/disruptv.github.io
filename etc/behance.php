<?php 
function get_behance( $user ) {
	
	require_once( get_template_directory() . '/bower_components/behance-api/dist/behance.php' );

	$client_id = 'x9vuFc2xdv0Co3KJAsmkCpGxjNwSzmOc';
	$client = new Behance\Client( $client_id );

	// Project data
	// $client->getProject( 2812719 );
	
	// Project's comments
	// $client->getProjectComments( 2812719 );
	
	// Featured project list
	// $client->searchProjects( array() );
	
	// Search for motorcycles
	// $client->searchProjects( array( 'q' => 'motorcycles' ) );

	$behance = (object)array_merge(
		//User data
		(array)$client->getUser($user),
		
		//User's projects
		array( 'projects' => (array)$client->getUserProjects($user) ),
		
		//User's works in progress
		array( 'wips' => (array)$client->getUserWips($user) )
	);
	
	return $behance;
}