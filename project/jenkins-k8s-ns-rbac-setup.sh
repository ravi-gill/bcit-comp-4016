#!/bin/bash

# Script to create namespace and grant Jenkins access

TARGET_NAMESPACE=$1
RBAC_FILE="rbac.yaml" # Path to your RoleBinding definition

if [ -z "$TARGET_NAMESPACE" ]; then
  echo "Usage: $0 <namespace_name>"
  exit 1
fi

echo "--- 1. Deleting Namespace (if it exists): $TARGET_NAMESPACE ---"
kubectl delete namespace "$TARGET_NAMESPACE" --ignore-not-found=true --timeout=30s

echo "--- 2. Creating Namespace: $TARGET_NAMESPACE ---"
kubectl create namespace "$TARGET_NAMESPACE" --dry-run=client -o yaml | kubectl apply -f -

echo "--- 3. Applying RBAC (Granting Jenkins Access) ---"

# This command dynamically updates the namespace in the RoleBinding file 
# and then applies the configuration.
# We use 'kubectl apply' here, as it's idempotent for the RoleBinding itself.
sed "s/<<target-namespace>>/$TARGET_NAMESPACE/g" "$RBAC_FILE" | kubectl apply -f -
echo "Setup complete. Jenkins ServiceAccount now has 'edit' access in $TARGET_NAMESPACE."