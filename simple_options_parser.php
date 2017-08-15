<?php

class SimpleOptionsParser
{
	const DOUBLE_DASH_WITH_VALUE_REGEX = '/^--(\S+?)=(.*)$/';
	const DOUBLE_DASH_REGEX = '/^--(\S+)$/';
	const SINGLE_DASH_REGEX = '/^-(\S+)$/';
	const PARAM_REGEX = '/^-(-?\S+)/';

	public function parse(array $args = null)
	{
		if (!is_array($args)) $args = $_SERVER['argv'];
		array_shift($args);

		$i = 0;
		$num_args = sizeof($args);
		$commands = [];
		$opts = [];

		while ($i < $num_args) {
			$current_arg = $args[$i];
			switch (true) {
				case (preg_match(self::DOUBLE_DASH_WITH_VALUE_REGEX, $current_arg, $matches)):
					$opts[$matches[1]] = $matches[2];
					$i++;
					break;
				case (preg_match(self::DOUBLE_DASH_REGEX, $current_arg, $matches)):
					if (strpos($current_arg, '--no-') === 0) {
						$opts[substr($current_arg, 5)] = false;
						$i++;
					} else {
						$params = $this->collect_params($args, $i + 1);
						$num_params = sizeof($params);
						if ($num_params == 0) $params = true;
						if ($num_params == 1) $params = $params[0];
						$opts[$matches[1]] = $params;
						$i = $i + ($num_params + 1);
					}
					break;
				case (preg_match(self::SINGLE_DASH_REGEX, $current_arg, $matches)):
					$params = $this->collect_params($args, $i + 1);
					for ($c = 0, $len = strlen($matches[1]); $c < $len; $c++) {
						$opts[$matches[1][$c]] = true;
					}
					$i++;
					break;
				default:
					$commands[] = $current_arg;
					$i++;
			}
		}

		$this->commands = $commands;
		$this->opts = $opts;

		return [
			'commands' => $commands,
			'opts' => $opts
		];
	}

//	protected

	protected function collect_params($args, $start_pos)
	{
		$params = [];
		$pos = $start_pos;

		while (isset($args[$pos]) && preg_match(self::PARAM_REGEX, $args[$pos]) !== 1) {
			$params[] = $args[$pos];
			$pos++;
		}

		return $params;
	}
}
