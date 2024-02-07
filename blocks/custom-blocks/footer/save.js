import { InnerBlocks, useBlockProps } from "@wordpress/block-editor";

export default function Save({ className }) {
  const blockProps = useBlockProps.save();

  return (
    <div
      {...blockProps}
      className={`${className || ""} zenfse_barbone-block footer`}
    >
      <InnerBlocks.Content />
    </div>
  );
}
