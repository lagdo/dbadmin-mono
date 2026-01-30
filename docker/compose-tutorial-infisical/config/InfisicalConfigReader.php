<?php

namespace App\Infisical;

use Infisical\SDK\Models\GetSecretParameters;
use Infisical\SDK\Models\Secret;
use Infisical\SDK\Services\SecretsService;
use Lagdo\DbAdmin\Db\Config\AuthInterface;
use Lagdo\DbAdmin\Db\Config\ConfigReader;
use Lagdo\Facades\Logger;

class InfisicalConfigReader extends ConfigReader
{
    public function __construct(private AuthInterface $auth,
        private SecretsService $secrets, private string $projectId,
        private string $environment, private string $secretPath = '')
    {}

    private function getSecret(string $secretKey): Secret
    {
        $params = new GetSecretParameters(
            secretKey: $secretKey,
            environment: $this->environment, // "dev",
            // secretPath: $this->secretPath,
            projectId: $this->projectId
        );

        return $this->secrets->get($params);
    }

    private function getSecretValue(string $prefix, string $option): string
    {
        // Make the Infisical secret key. The injected auth interface can be
        // used here to customize the secret key depending on the current user.
        $secretKey = "users.{$prefix}.{$option}";
        $secretValue = $this->getSecret($secretKey)->secretValue;
        Logger::info('Read secret', compact('secretKey', 'secretValue'));
        return $secretValue;
    }

    /**
     * @inheritDoc
     */
    protected function getUsername(string $prefix): string
    {
        return $this->getSecretValue($prefix, 'username');
    }

    /**
     * @inheritDoc
     */
    protected function getPassword(string $prefix): string
    {
        return $this->getSecretValue($prefix, 'password');
    }
}
