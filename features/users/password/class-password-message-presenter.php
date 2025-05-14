<?php

namespace Helsinki\WordPress\Site\Core\Features\Users\Password;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Exception;

class Password_Message_Presenter
{
	public function hints( array $hints ): string
	{
		return \wp_kses(
			sprintf(
				'<div class="helsinki-password-hints">
					<h2>%s</h2>
					%s
				</div>',
				__( 'Helsinki password requirements', 'helsinki-site-core' ),
				$this->to_html_list( $hints )
			),
			$this->allowed_html(),
		);
	}

	public function validation_errors( Exception $exception ): string
	{
		return $this->to_html_list(
			array_map(
				array( $this, 'error_line' ),
				$this->exception_messages( $exception )
			)
		);
	}

	private function to_html_list( array $items ): string
	{
		$items = array_map( array( $this, 'to_html_list_item' ), $items );

		return \wp_kses(
			sprintf( '<ul>%s</ul>', implode( '', $items ) ),
			$this->allowed_html(),
		);
	}

	private function to_html_list_item( string $content ): string
	{
		return sprintf( '<li>%s</li>', $content );
	}

	private function error_line( string $error ): string
	{
		return sprintf(
			'<strong>%s:</strong> %s',
			__( 'Error', 'helsinki-site-core' ),
			$error
		);
	}

	private function allowed_html(): array
	{
		return array(
			'div' => array( 'class' => array() ),
			'h2' => array(),
			'ul' => array(),
			'li' => array(),
			'strong' => array(),
		);
	}

	private function exception_messages( Exception $exception ): array
	{
		$messages = array();

		do {
			$messages[] = $exception->getMessage();
		} while ( $exception = $exception->getPrevious() );

		return array_reverse( $messages );
	}
}
