<?php

namespace Tablelite;

class Feature
{
    public function __construct(
        protected array $features = []
    ) {
    }

    public function add(FeatureType $featureType): static
    {
        $this->features[] = $featureType;
        return $this;
    }

    public function remove(FeatureType $featureType): static
    {
        $this->features = array_filter($this->features, fn($feature) => $feature !== $featureType);
        return $this;
    }

    public function has(string|FeatureType $featureType): bool
    {
        if (!$featureType instanceof FeatureType) {
            $featureType = FeatureType::from($featureType);
        }
        return in_array($featureType, $this->features);
    }
}
