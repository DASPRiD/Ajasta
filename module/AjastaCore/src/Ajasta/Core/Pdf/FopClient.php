<?php
namespace Ajasta\Core\Pdf;

use RuntimeException;

class FopClient
{
    /**
     * @var string
     */
    protected $fopPath;

    /**
     * @param string $fopPath
     */
    public function __construct($fopPath)
    {
        $this->fopPath = $fopPath;
    }

    /**
     * @param string $xmlPath
     * @param string $xslPath
     * @param string $outputPath
     */
    public function generatePdf($xmlPath, $xslPath, $outputPath)
    {
        $command = sprintf(
            '%s -xml %s -xsl %s -pdf %s',
            escapeshellcmd($this->fopPath),
            escapeshellarg($xmlPath),
            escapeshellarg($xslPath),
            escapeshellarg($outputPath)
        );
        $descriptorSpecs = [
            ['pipe', 'r'],
            ['pipe', 'w'],
            ['pipe', 'w'],
        ];

        $process = proc_open(
            $command,
            $descriptorSpecs,
            $pipes
        );

        if (!is_resource($process)) {
            throw new RuntimeException('Could not create process');
        }

        fclose($pipes[0]);
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);

        $exitCode = proc_close($process);

        if ($exitCode > 0) {
            throw new RuntimeException(sprintf(
                "Error while running `%s`:\n%s",
                $command,
                $stderr
            ));
        }
    }
}
