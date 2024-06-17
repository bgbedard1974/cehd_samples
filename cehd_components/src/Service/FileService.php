<?php


namespace Drupal\cehd_components\Service;


use Symfony\Component\Yaml\Yaml;


class FileService {

  /**
   * This method takes a file path and reads the data into a string
   * @param string $file_path
   *
   * @return string
   */
  public function read(string $file_path): string {
    return file_get_contents($file_path);
  }

  /**
   * This method takes a file path and reads the data into an array where
   * each element is a line.
   * @param string $file_path
   *
   * @return array
   */
  public function readLines(string $file_path): array {
    $contents = $this->read($file_path);
    $lines = explode("\n", $contents);
    $cleaned_lines = [];
    foreach ($lines as $line) {
      $cleaned_lines[] = rtrim($line);
    }
    array_pop($cleaned_lines);
    return $cleaned_lines;
  }

  /**
   * This method writes a string to the given file path
   * @param string $file_path
   * @param string $contents
   */
  public function write(string $file_path, string $contents) {
    file_put_contents($file_path, $contents);
  }

  /**
   * This method takes an array and creates a string to write to a file
   * @param string $file_path
   * @param array $lines
   */
  public function writeLines(string $file_path, array $lines) {
    $contents = implode("\n", $lines);
    //$contents = implode($lines, "\n");
    $contents .= "\n";
    $this->write($file_path, $contents);
  }

  /**
   * This method takes a module and file name and constructs a file path to that module's
   * data directory.
   *
   * @param string $module_name
   * @param string $file_name
   *
   * @return string
   */
  public function getDataPath(string $module_name, string $file_name): string {
    return DRUPAL_ROOT . '/' . \Drupal::service('module_handler')->getModule($module_name)->getPath() . '/data/' . $file_name;
  }

  /**
   * This method reads data from a YAML file and parses it into a PHP array
   * @param string $file_path
   *
   * @return array
   */
  public function readYaml(string $file_path): array {
    return Yaml::parseFile($file_path);
  }

  /**
   * This method takes a PHP array and writes a YAML file out of it.
   * @param string $file_path
   * @param array $data
   */
  public function writeYaml(string $file_path, array $data) {
    $contents = Yaml::dump($data);
    $this->write($file_path, $contents);
  }

}
