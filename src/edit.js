import { __ } from '@wordpress/i18n';

import ServerSideRender from '@wordpress/server-side-render';

import { useBlockProps, InspectorControls } from '@wordpress/block-editor';

import { useSelect } from '@wordpress/data';

import {
	Disabled,
	PanelBody,
	PanelRow,
	ComboboxControl
} from '@wordpress/components';

import metadata from './block.json';
import './editor.scss';

export default function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps( {
		className: 'embed-post-prop',
	} );

	const { selectedPost } = attributes;

	// Query the database and get our list of posts to use in the ComboboxControl
	const posts = useSelect( ( select ) => {
		return select( 'core' ).getEntityRecords( 'postType', 'post' );
	}, [] );

	let options = [];

	// Format the posts we found into for display
    if ( posts ) {
		options.push( { value: 0, label: 'Select a post' } )
		posts.forEach( ( post ) => {
			options.push( { value : post.id, label : post.title.rendered } )
		})
    } else {
		options.push( { value: 0, label: 'Loading...' } )
	}

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __( 'Settings', 'dynamic-block' ) }
					initialOpen={ true }
				>
					<PanelRow>
						<div class="combo-box-embed-post">
							<ComboboxControl  
								label="Select a post"
								value={ selectedPost }
								options={ options }
								onChange= { ( post_id ) => setAttributes( { selectedPost: Number( post_id ) } ) }
							/>
						</div>
					</PanelRow>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<Disabled>
					<ServerSideRender
						block={ metadata.name }
						skipBlockSupportAttributes
						attributes={ attributes }
					/>
				</Disabled>
			</div>
		</>
	);
}